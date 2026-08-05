<x-app-layout>
    @php
        $firstName = explode(' ', trim($user->name))[0];
    @endphp

    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-400">Selamat datang kembali</p>
            <h2 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $firstName }}, lanjutkan aktivitas olahraga Anda.</h2>
        </div>
    </x-slot>

    <div class="bg-gradient-to-b from-indigo-50 via-gray-50 to-gray-100 py-8 dark:from-gray-900 dark:via-gray-900 dark:to-gray-950 sm:py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if(session('status'))
                <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 shadow-sm dark:border-emerald-900/60 dark:bg-emerald-950/30 dark:text-emerald-200">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-xs font-bold text-white">&#10003;</span>
                    <p class="pt-0.5 font-medium">{{ session('status') }}</p>
                </div>
            @endif

            @if($isOwner)
                <div class="mb-8 flex flex-col gap-5 rounded-2xl bg-indigo-950 p-6 text-white shadow-xl shadow-indigo-950/10 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-lime-300">Owner workspace</p>
                        <h3 class="mt-2 text-2xl font-bold">Kelola venue dan pesanan penyewa Anda.</h3>
                        <p class="mt-2 max-w-2xl text-sm leading-6 text-indigo-200">Pantau pesanan masuk, konfirmasi pembayaran, dan pastikan setiap lapangan memiliki slot jadwal yang aktif.</p>
                    </div>
                    <a href="{{ route('owner.fields.index') }}" class="inline-flex shrink-0 items-center justify-center rounded-lg bg-lime-300 px-4 py-3 text-sm font-bold text-indigo-950 transition hover:bg-lime-200">Kelola lapangan</a>
                </div>

                <section class="mb-8 grid gap-4 sm:grid-cols-3" aria-label="Ringkasan owner">
                    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total lapangan</p>
                        <div class="mt-3 flex items-end justify-between">
                            <p class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $fieldsCount }}</p>
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 text-lg text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">&#9962;</span>
                        </div>
                    </div>
                    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Perlu konfirmasi</p>
                        <div class="mt-3 flex items-end justify-between">
                            <p class="text-3xl font-bold tracking-tight text-amber-600 dark:text-amber-400">{{ $needsAction }}</p>
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-lg text-amber-700 dark:bg-amber-900 dark:text-amber-200">&#9203;</span>
                        </div>
                    </div>
                    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pesanan lunas</p>
                        <div class="mt-3 flex items-end justify-between">
                            <p class="text-3xl font-bold tracking-tight text-emerald-600 dark:text-emerald-400">{{ $paidCount }}</p>
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-lg text-emerald-700 dark:bg-emerald-900 dark:text-emerald-200">&#10003;</span>
                        </div>
                    </div>
                </section>

                <div class="grid gap-6 md:grid-cols-2">
                    <a href="{{ route('owner.fields.index') }}" class="group overflow-hidden rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl hover:shadow-indigo-950/10 dark:border-gray-700 dark:bg-gray-800">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-100 text-lg text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">&#9962;</span>
                        <h3 class="mt-4 text-lg font-bold text-gray-900 dark:text-white">Kelola lapangan saya</h3>
                        <p class="mt-2 text-sm leading-6 text-gray-500 dark:text-gray-400">Tambah, edit, atau atur slot jadwal setiap lapangan agar katalog selalu akurat.</p>
                        <p class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-indigo-600 dark:text-indigo-300">Buka <span class="transition group-hover:translate-x-1" aria-hidden="true">&rarr;</span></p>
                    </a>
                    <a href="{{ route('owner.bookings') }}" class="group overflow-hidden rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl hover:shadow-indigo-950/10 dark:border-gray-700 dark:bg-gray-800">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-100 text-lg text-amber-700 dark:bg-amber-900 dark:text-amber-200">&#9993;</span>
                        <h3 class="mt-4 text-lg font-bold text-gray-900 dark:text-white">Pesanan masuk</h3>
                        <p class="mt-2 text-sm leading-6 text-gray-500 dark:text-gray-400">Tinjau bukti pembayaran dan konfirmasi pesanan penyewa yang sudah dibayar.</p>
                        <p class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-indigo-600 dark:text-indigo-300">Buka <span class="transition group-hover:translate-x-1" aria-hidden="true">&rarr;</span></p>
                    </a>
                </div>
            @else
                <div class="mb-8 flex flex-col gap-5 rounded-2xl bg-indigo-950 p-6 text-white shadow-xl shadow-indigo-950/10 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-lime-300">Siap bermain</p>
                        <h3 class="mt-2 text-2xl font-bold">Temukan lapangan dan pantau pesanan Anda.</h3>
                        <p class="mt-2 max-w-2xl text-sm leading-6 text-indigo-200">Cari venue berdasarkan lokasi dan olahraga, pilih slot jadwal, lalu selesaikan pembayaran dalam beberapa langkah.</p>
                    </div>
                    <a href="{{ route('fields.index') }}" class="inline-flex shrink-0 items-center justify-center rounded-lg bg-lime-300 px-4 py-3 text-sm font-bold text-indigo-950 transition hover:bg-lime-200">Cari lapangan</a>
                </div>

                <section class="mb-8 grid gap-4 sm:grid-cols-3" aria-label="Ringkasan pesanan">
                    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total pesanan</p>
                        <div class="mt-3 flex items-end justify-between">
                            <p class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $totalBookings }}</p>
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 text-lg text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">&#9636;</span>
                        </div>
                    </div>
                    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Perlu pembayaran</p>
                        <div class="mt-3 flex items-end justify-between">
                            <p class="text-3xl font-bold tracking-tight text-amber-600 dark:text-amber-400">{{ $needsPayment }}</p>
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-lg text-amber-700 dark:bg-amber-900 dark:text-amber-200">!</span>
                        </div>
                    </div>
                    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pesanan lunas</p>
                        <div class="mt-3 flex items-end justify-between">
                            <p class="text-3xl font-bold tracking-tight text-emerald-600 dark:text-emerald-400">{{ $paidBookings }}</p>
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-lg text-emerald-700 dark:bg-emerald-900 dark:text-emerald-200">&#10003;</span>
                        </div>
                    </div>
                </section>

                <div class="grid gap-6 md:grid-cols-2">
                    <a href="{{ route('fields.index') }}" class="group overflow-hidden rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl hover:shadow-indigo-950/10 dark:border-gray-700 dark:bg-gray-800">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-100 text-lg text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">&#9917;</span>
                        <h3 class="mt-4 text-lg font-bold text-gray-900 dark:text-white">Jelajahi lapangan</h3>
                        <p class="mt-2 text-sm leading-6 text-gray-500 dark:text-gray-400">Cari venue olahraga berdasarkan kota, kategori, dan rentang harga yang sesuai anggaran Anda.</p>
                        <p class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-indigo-600 dark:text-indigo-300">Mulai cari <span class="transition group-hover:translate-x-1" aria-hidden="true">&rarr;</span></p>
                    </a>
                    <a href="{{ route('bookings.index') }}" class="group overflow-hidden rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl hover:shadow-indigo-950/10 dark:border-gray-700 dark:bg-gray-800">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-100 text-lg text-violet-700 dark:bg-violet-900 dark:text-violet-200">&#128203;</span>
                        <h3 class="mt-4 text-lg font-bold text-gray-900 dark:text-white">Pesanan saya</h3>
                        <p class="mt-2 text-sm leading-6 text-gray-500 dark:text-gray-400">Pantau status booking, lanjutkan pembayaran, dan lihat detail reservasi Anda dalam satu tempat.</p>
                        <p class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-indigo-600 dark:text-indigo-300">Lihat pesanan <span class="transition group-hover:translate-x-1" aria-hidden="true">&rarr;</span></p>
                    </a>
                </div>

                <div class="mt-6 rounded-2xl border border-indigo-100 bg-white p-5 text-sm text-gray-600 shadow-sm dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                    <p class="font-bold text-gray-900 dark:text-white">Ingin menyewakan lapangan Anda?</p>
                    <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">Daftarkan diri sebagai pemilik lapangan untuk mengelola venue, slot jadwal, dan menerima pesanan penyewa.</p>
                    <a href="{{ route('owner.register') }}" class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-indigo-600 dark:text-indigo-300">Daftar jadi pemilik <span aria-hidden="true">&rarr;</span></a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
