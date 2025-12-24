<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Hanya generate jika NIA belum ada, dan Data Pendukung Lengkap
        if (is_null($user->nia) && $user->join_year && $user->date_of_birth) {
            $this->generateNia($user);
        }
    }

    /**
     * Logic Generator NIA yang Aman dari Konflik
     */
    private function generateNia(User $user)
    {
        // Format: YYYY (Join) + DDMMYYYY (TTL) + XXXX (Urut)
        // Contoh: 2019 + 04052004 + 0001

        $yearJoined = $user->join_year;
        $dob = $user->date_of_birth->format('dmY'); // Format 04052004
        $prefix = $yearJoined . $dob; // Prefix dasar (tapi urutan reset per tahun masuk)

        // KITA GUNAKAN DATABASE TRANSACTION & LOCKING
        // Untuk mencegah dua orang mendaftar di detik yang sama mendapat nomor sama.

        // 1. Cari user terakhir di TAHUN MASUK yang sama yang sudah punya NIA
        // Kita kunci baris terakhir agar tidak dibaca process lain sampai ini selesai
        $lastUser = User::where('join_year', $yearJoined)
            ->whereNotNull('nia')
            ->orderBy('nia', 'desc') // Ambil nomor terbesar
            ->lockForUpdate() // PENTING: Locking
            ->first();

        if ($lastUser) {
            // Ambil 4 digit terakhir dari NIA user terakhir
            $lastSequence = intval(substr($lastUser->nia, -4));
            $nextSequence = $lastSequence + 1;
        } else {
            // Jika belum ada user di tahun masuk tersebut
            $nextSequence = 1;
        }

        // Format 4 digit angka (0001, 0002, dst)
        $sequenceStr = str_pad($nextSequence, 4, '0', STR_PAD_LEFT);

        // Set NIA final
        $user->nia = $yearJoined . $dob . $sequenceStr;
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // // Cek apakah NIA masih kosong?
        // // Dan apakah user BARU SAJA melengkapi data yang dibutuhkan (join_year / dob)?
        // if (is_null($user->nia) && $user->join_year && $user->date_of_birth) {

        //     // Generate NIA sekarang
        //     $this->generateNia($user);

        //     // Simpan perubahan (tanpa men-trigger event updated lagi agar tidak loop infinite)
        //     $user->saveQuietly();
        // }

        // 1. CEK PERUBAHAN DATA SENSITIF
        if ($user->isDirty(User::VERIFIABLE_ATTRIBUTES)) {
            $this->handleVerifiableDataChange($user);
        }

        // 2. GENERATE NIA (Hanya jika status berubah jadi approved DAN belum punya NIA)
        if (
            $user->isDirty('verification_status') &&
            $user->verification_status === 'approved' &&
            is_null($user->nia)
        ) {

            $this->generateNia($user);
        }
    }

    /**
     * Logic Inti: Bandingkan data baru dengan Snapshot Terakhir
     */
    private function handleVerifiableDataChange(User $user)
    {
        // Jika user belum pernah diverifikasi sama sekali, biarkan logic default (biasanya pending/incomplete)
        $lastVerification = $user->latestVerification()->first();

        if (! $lastVerification) {
            $user->verification_status = 'pending';
            return;
        }

        // Ambil Snapshot Data Lama
        $snapshot = $lastVerification->snapshot_data; // Array dari JSON

        // Bandingkan Data Input Baru vs Snapshot
        $isMatch = true;
        foreach (User::VERIFIABLE_ATTRIBUTES as $attribute) {
            // Ambil value baru (yang sedang disubmit)
            $newValue = $user->$attribute;

            // Ambil value lama dari snapshot (gunakan null coalescing operator)
            $snapshotValue = $snapshot[$attribute] ?? null;

            // Normalisasi perbandingan (karena JSON decode mungkin beda tipe data dengan Model Cast)
            // Contoh: "2023" (string) vs 2023 (int) atau Date Object vs String Date
            if ($attribute === 'date_of_birth' && $newValue instanceof \DateTime) {
                $newValue = $newValue->format('Y-m-d');
                // Pastikan snapshot formatnya juga Y-m-d (biasanya string dari JSON)
                $snapshotValue = substr($snapshotValue, 0, 10);
            }

            // Loose comparison (==) cukup aman untuk string/int form data
            if ($newValue != $snapshotValue) {
                $isMatch = false;
                break; // Ada satu saja beda, langsung break
            }
        }

        if ($isMatch) {
            // MAGIC MOMENT: User mengembalikan data ke kondisi terakhir yg di-ACC
            $user->verification_status = 'approved';
        } else {
            // Data berbeda dari snapshot terakhir
            $user->verification_status = 'pending';
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
