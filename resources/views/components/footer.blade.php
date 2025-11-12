    <!-- 8. Footer (Versi Lengkap) -->
    <footer class="bg-gray-300 dark:bg-slate-800 border-t border-slate-400 dark:border-slate-700">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

          <!-- Kolom 1: Logo dan Deskripsi -->
          <div>
            <div class="flex items-center space-x-3 mb-4">
              <!-- Ganti dengan Logo Anda -->
              <x-application-logo class="h-8 w-10" />
              <span class="text-xl font-semibold text-gray-700 dark:text-white">geTix PD</span>
            </div>
            <p class="text-gray-600 dark:text-gray-400 text-sm max-w-xs">
              Platform e-ticketing resmi untuk semua kegiatan Keluarga Silat Nasional Indonesia Perisai Diri. Dapatkan
              tiket Anda dengan mudah, aman, dan cepat.
            </p>
          </div>

          <!-- Kolom 2: Tautan Penting -->
          <div>
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-4">Tautan Cepat
            </h3>
            <ul class="space-y-3">
              <li>
                <a href="/"
                  class="inline-block text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white text-sm">Home</a>
              </li>
              <li>
                <a href="/events"
                  class="inline-block text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white text-sm">Semua
                  Event</a>
              </li>
              <li>
                <a href="/my-tickets"
                  class="inline-block text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white text-sm">Tiket
                  Saya</a>
              </li>
            </ul>
          </div>

          <!-- Kolom 3: Media Sosial -->
          <div>
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-4">Ikuti Kami
            </h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
              Dapatkan info event terbaru melalui media sosial resmi Perisai Diri.
            </p>
            <div class="flex space-x-5">
              <a href="https://www.instagram.com/pd_kabtasikofc/"
                class="text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white transition duration-300">
                <span class="sr-only">Instagram</span>
                <!-- Icon Instagram -->
                <svg class="size-7" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                  <path
                    d="M290.4 275.7C274 286 264.5 304.5 265.5 323.8C266.6 343.2 278.2 360.4 295.6 368.9C313.1 377.3 333.8 375.5 349.6 364.3C366 354 375.5 335.5 374.5 316.2C373.4 296.8 361.8 279.6 344.4 271.1C326.9 262.7 306.2 264.5 290.4 275.7zM432.7 207.3C427.5 202.1 421.2 198 414.3 195.3C396.2 188.2 356.7 188.5 331.2 188.8C327.1 188.8 323.3 188.9 320 188.9C316.7 188.9 312.8 188.9 308.6 188.8C283.1 188.5 243.8 188.1 225.7 195.3C218.8 198 212.6 202.1 207.3 207.3C202 212.5 198 218.8 195.3 225.7C188.2 243.8 188.6 283.4 188.8 308.9C188.8 313 188.9 316.8 188.9 320C188.9 323.2 188.9 327 188.8 331.1C188.6 356.6 188.2 396.2 195.3 414.3C198 421.2 202.1 427.4 207.3 432.7C212.5 438 218.8 442 225.7 444.7C243.8 451.8 283.3 451.5 308.8 451.2C312.9 451.2 316.7 451.1 320 451.1C323.3 451.1 327.2 451.1 331.4 451.2C356.9 451.5 396.2 451.9 414.3 444.7C421.2 442 427.4 437.9 432.7 432.7C438 427.5 442 421.2 444.7 414.3C451.9 396.3 451.5 356.9 451.2 331.3C451.2 327.1 451.1 323.2 451.1 319.9C451.1 316.6 451.1 312.8 451.2 308.5C451.5 283 451.9 243.6 444.7 225.5C442 218.6 437.9 212.4 432.7 207.1L432.7 207.3zM365.6 251.8C383.7 263.9 396.2 282.7 400.5 304C404.8 325.3 400.3 347.5 388.2 365.6C382.2 374.6 374.5 382.2 365.6 388.2C356.7 394.2 346.6 398.3 336 400.4C314.7 404.6 292.5 400.2 274.4 388.1C256.3 376 243.8 357.2 239.5 335.9C235.2 314.6 239.7 292.4 251.7 274.3C263.7 256.2 282.6 243.7 303.9 239.4C325.2 235.1 347.4 239.6 365.5 251.6L365.6 251.6zM394.8 250.5C391.7 248.4 389.2 245.4 387.7 241.9C386.2 238.4 385.9 234.6 386.6 230.8C387.3 227 389.2 223.7 391.8 221C394.4 218.3 397.9 216.5 401.6 215.8C405.3 215.1 409.2 215.4 412.7 216.9C416.2 218.4 419.2 220.8 421.3 223.9C423.4 227 424.5 230.7 424.5 234.5C424.5 237 424 239.5 423.1 241.8C422.2 244.1 420.7 246.2 419 248C417.3 249.8 415.1 251.2 412.8 252.2C410.5 253.2 408 253.7 405.5 253.7C401.7 253.7 398 252.6 394.9 250.5L394.8 250.5zM544 160C544 124.7 515.3 96 480 96L160 96C124.7 96 96 124.7 96 160L96 480C96 515.3 124.7 544 160 544L480 544C515.3 544 544 515.3 544 480L544 160zM453 453C434.3 471.7 411.6 477.6 386 478.9C359.6 480.4 280.4 480.4 254 478.9C228.4 477.6 205.7 471.7 187 453C168.3 434.3 162.4 411.6 161.2 386C159.7 359.6 159.7 280.4 161.2 254C162.5 228.4 168.3 205.7 187 187C205.7 168.3 228.5 162.4 254 161.2C280.4 159.7 359.6 159.7 386 161.2C411.6 162.5 434.3 168.3 453 187C471.7 205.7 477.6 228.4 478.8 254C480.3 280.3 480.3 359.4 478.8 385.9C477.5 411.5 471.7 434.2 453 452.9L453 453z" />
                </svg>
              </a>
              <a href="https://www.youtube.com/@perisaidirikabtasikofficial"
                class="text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white transition duration-300">
                <span class="sr-only">YouTube</span>
                <!-- Icon YouTube -->
                <svg class="size-7" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                  <path
                    d="M581.7 188.1C575.5 164.4 556.9 145.8 533.4 139.5C490.9 128 320.1 128 320.1 128C320.1 128 149.3 128 106.7 139.5C83.2 145.8 64.7 164.4 58.4 188.1C47 231 47 320.4 47 320.4C47 320.4 47 409.8 58.4 452.7C64.7 476.3 83.2 494.2 106.7 500.5C149.3 512 320.1 512 320.1 512C320.1 512 490.9 512 533.5 500.5C557 494.2 575.5 476.3 581.8 452.7C593.2 409.8 593.2 320.4 593.2 320.4C593.2 320.4 593.2 231 581.8 188.1zM264.2 401.6L264.2 239.2L406.9 320.4L264.2 401.6z" />
                </svg>
              </a>
              <a href="https://www.facebook.com/groups/122776311120420"
                class="text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white transition duration-300">
                <span class="sr-only">Facebook</span>
                <!-- Icon Facebook -->
                <svg class="size-7" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                  <path
                    d="M576 320C576 178.6 461.4 64 320 64C178.6 64 64 178.6 64 320C64 440 146.7 540.8 258.2 568.5L258.2 398.2L205.4 398.2L205.4 320L258.2 320L258.2 286.3C258.2 199.2 297.6 158.8 383.2 158.8C399.4 158.8 427.4 162 438.9 165.2L438.9 236C432.9 235.4 422.4 235 409.3 235C367.3 235 351.1 250.9 351.1 292.2L351.1 320L434.7 320L420.3 398.2L351 398.2L351 574.1C477.8 558.8 576 450.9 576 320z" />
                </svg>
              </a>
            </div>
          </div>
        </div>

        <!-- Garis Pemisah dan Copyright -->
        <div class="mt-8 -mb-5 border-t border-slate-400 dark:border-slate-700 pt-6 text-center">
          <p class="text-sm text-gray-600 dark:text-gray-500">
            &copy; 2025 E-Ticketing App (geTix PD). All rights reserved.
          </p>
        </div>
      </div>
    </footer>
