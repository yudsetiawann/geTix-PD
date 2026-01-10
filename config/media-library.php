<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Ini adalah "saklar" utama yang kita buat.
    | Spatie Media Library akan menggunakan disk yang ditentukan di sini.
    | Kita mengarahkannya untuk membaca variabel default_public_disk
    | dari file filesystems.php Anda.
    |
    */
    // 'disk_name' => config('filesystems.default_public_disk', 'public'),
    'disk_name' => env('MEDIA_DISK', 'public'),
];
