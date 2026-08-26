<x-app-layout>
    {{-- Tidak menggunakan x-slot header agar welcome & hero menyatu dalam satu area tanpa pemisah --}}

    {{-- =====================================================================
         UNIFIED HERO AREA — Welcome + Hero + Search (satu aliran visual)
    ====================================================================== --}}
    <div class="relative overflow-hidden bg-indigo-950 pb-16 pt-8 sm:pt-10">

        {{-- Ambient Glow Decorations --}}
        <div class="pointer-events-none absolute -right-32 -top-32 h-[420px] w-[420px] rounded-full bg-indigo-700/20 blur-3xl"></div>
        <div class="pointer-events-none absolute -left-20 bottom-0 h-80 w-80 rounded-full bg-violet-700/15 blur-3xl"></div>
        <div class="pointer-events-none absolute right-1/4 bottom-0 h-64 w-64 rounded-full bg-lime-400/8 blur-3xl"></div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Flash Status --}}
            @if(session('status'))
                <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-400/30 bg-emerald-500/15 p-4 text-sm text-emerald-200 backdrop-blur-sm">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-emerald-500 text-xs font-bold text-white">✓</span>
                    <p class="font-medium">{{ session('status') }}</p>
                </div>
            @endif

            {{-- Owner Banner --}}
            @if($isOwner)
                <div class="mb-6 flex flex-col gap-3 rounded-2xl border border-indigo-700/50 bg-indigo-900/60 p-4 backdrop-blur-sm sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-indigo-600 text-lg shadow-sm">🏢</span>
                        <div>
                            <p class="text-sm font-bold text-white">Anda terdaftar sebagai Pemilik Lapangan</p>
                            <p class="text-xs text-indigo-300">Kelola venue, slot jadwal, dan pesanan masuk dari penyewa Anda.</p>
                        </div>
                    </div>
                    <a href="{{ route('owner.dashboard') }}" class="inline-flex shrink-0 items-center justify-center rounded-xl bg-indigo-600 px-4 py-2 text-xs font-bold text-white transition hover:bg-indigo-500">
                        Buka Workspace Owner &rarr;
                    </a>
                </div>
            @endif

            {{-- ── Welcome Greeting (tanpa border/card, menyatu dengan hero) ── --}}
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between lg:gap-8">
                <div class="min-w-0 lg:max-w-4xl">
            <div class="mb-6">
                <div class="flex items-center gap-2 mb-2">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-900/70 px-3 py-1 text-xs font-semibold text-lime-300 border border-indigo-700/50">
                        <span class="h-1.5 w-1.5 rounded-full bg-lime-400"></span>
                        {{ now()->translatedFormat('l, d F Y') }}
                    </span>
                </div>
                <h1 class="text-2xl font-black tracking-tight text-white sm:text-3xl md:text-4xl">
                    Selamat datang kembali, <span class="text-lime-300">{{ $user->name }}</span>! 👋
                </h1>
                <p class="mt-1.5 text-sm text-indigo-300 sm:text-base">
                    Siap untuk sesi olahraga hari ini? Temukan lapangan favoritmu di bawah.
                </p>
            </div>

            {{-- ── Hero Headline ── --}}
            <div class="mb-7 max-w-4xl">
                {{-- Badge --}}
                <div class="mb-4 inline-flex items-center gap-2.5 rounded-full border border-indigo-700/60 bg-indigo-900/80 px-4 py-1.5 text-xs font-bold text-lime-300 backdrop-blur-md sm:text-sm">
                    <span class="h-2 w-2 rounded-full bg-lime-400 animate-pulse"></span>
                    Platform #1 Sewa Lapangan di Indonesia
                </div>

                {{-- Main Headline --}}
                <h2 class="text-3xl font-black tracking-tight text-white leading-[1.12] sm:text-4xl md:text-5xl lg:text-6xl">
                    Temukan Lapangan <span class="text-lime-300">Impianmu</span><br class="hidden sm:block"> dalam Hitungan Detik
                </h2>

                {{-- Subtitle --}}
                <p class="mt-4 text-sm font-medium leading-relaxed text-indigo-200 sm:text-base md:text-lg max-w-3xl">
                    Ribuan lapangan olahraga berkualitas siap kamu booking. Dari futsal, basket, badminton, hingga tennis — semua ada di ArenaGo!
                </p>
            </div>
                </div>
                <x-dashboard-hero-mascot />
            </div>

        </div>{{-- /container --}}
    </div>{{-- /unified hero --}}

    {{-- =====================================================================
         MAIN CONTENT AREA — Stats, Cards, etc. (on indigo-950 bg)
    ====================================================================== --}}
    <div class="bg-indigo-950 pb-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Stats Grid --}}
            <section aria-label="Ringkasan pesanan">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold text-indigo-200">Ringkasan Aktivitas</h3>
                    <a href="{{ route('bookings.index') }}" class="text-xs font-bold text-lime-300 hover:text-lime-200">Lihat semua &rarr;</a>
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    {{-- Total Pesanan --}}
                    <div class="group flex flex-col justify-between rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200/80 transition hover:shadow-md dark:bg-gray-900 dark:ring-gray-800">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-gray-500">Total Reservasi</span>
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-950/60 dark:text-indigo-400 group-hover:scale-110 transition-transform">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="text-3xl font-black tracking-tight text-slate-900 dark:text-white">{{ $totalBookings }}</p>
                            <p class="mt-1 text-xs text-slate-500 dark:text-gray-400">Total pesanan yang pernah dibuat</p>
                        </div>
                    </div>

                    {{-- Perlu Pembayaran --}}
                    <div class="group flex flex-col justify-between rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200/80 transition hover:shadow-md dark:bg-gray-900 dark:ring-gray-800">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-gray-500">Perlu Pembayaran</span>
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-950/60 dark:text-amber-400 group-hover:scale-110 transition-transform">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="flex items-baseline gap-2">
                                <p class="text-3xl font-black tracking-tight text-amber-600 dark:text-amber-400">{{ $needsPayment }}</p>
                                @if($needsPayment > 0)
                                    <span class="rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-extrabold text-amber-800 dark:bg-amber-950 dark:text-amber-300">Pending</span>
                                @endif
                            </div>
                            <p class="mt-1 text-xs text-slate-500 dark:text-gray-400">
                                @if($needsPayment > 0)
                                    <a href="{{ route('bookings.index') }}" class="font-bold text-amber-600 hover:underline dark:text-amber-400">Unggah bukti bayar &rarr;</a>
                                @else
                                    Semua transaksi aman
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- Pesanan Lunas --}}
                    <div class="group flex flex-col justify-between rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200/80 transition hover:shadow-md dark:bg-gray-900 dark:ring-gray-800">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-gray-500">Pesanan Lunas</span>
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/60 dark:text-emerald-400 group-hover:scale-110 transition-transform">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="text-3xl font-black tracking-tight text-emerald-600 dark:text-emerald-400">{{ $paidBookings }}</p>
                            <p class="mt-1 text-xs text-slate-500 dark:text-gray-400">Reservasi terkonfirmasi &amp; lunas</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Quick Action Cards --}}
            <section>
                <h3 class="mb-4 text-base font-bold text-indigo-200">Aksi Cepat</h3>
                <div class="grid gap-5 md:grid-cols-2">
                    <a href="{{ route('fields.index') }}" class="group flex flex-col justify-between overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-indigo-500/8 dark:border-gray-800 dark:bg-gray-900">
                        <div>
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50 text-xl text-indigo-600 group-hover:scale-110 transition-transform dark:bg-indigo-950/80 dark:text-indigo-300">🏟️</span>
                            <h4 class="mt-4 text-base font-black text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">Jelajahi Katalog Lapangan</h4>
                            <p class="mt-2 text-xs leading-relaxed text-slate-500 dark:text-gray-400">Cari venue olahraga berdasarkan kota, kategori, rating, dan harga per jam.</p>
                        </div>
                        <p class="mt-5 inline-flex items-center gap-1 text-xs font-bold text-indigo-600 dark:text-indigo-400">
                            Mulai cari <span class="transition-transform group-hover:translate-x-1">&rarr;</span>
                        </p>
                    </a>

                    <a href="{{ route('bookings.index') }}" class="group flex flex-col justify-between overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-violet-500/8 dark:border-gray-800 dark:bg-gray-900">
                        <div>
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-50 text-xl text-violet-600 group-hover:scale-110 transition-transform dark:bg-violet-950/80 dark:text-violet-300">📋</span>
                            <h4 class="mt-4 text-base font-black text-slate-900 dark:text-white group-hover:text-violet-600 dark:group-hover:text-violet-400 transition-colors">Kelola Pesanan Saya</h4>
                            <p class="mt-2 text-xs leading-relaxed text-slate-500 dark:text-gray-400">Pantau status booking, unggah bukti pembayaran, dan lihat detail reservasi.</p>
                        </div>
                        <p class="mt-5 inline-flex items-center gap-1 text-xs font-bold text-violet-600 dark:text-violet-400">
                            Lihat pesanan <span class="transition-transform group-hover:translate-x-1">&rarr;</span>
                        </p>
                    </a>
                </div>
            </section>

            {{-- Daftar Jadi Pemilik (Non-owner only) --}}
            @if(!$isOwner)
                <div class="rounded-2xl border border-indigo-800/60 bg-indigo-900/50 p-6 sm:p-8 backdrop-blur-sm">
                    <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                        <div>
                            <span class="inline-flex items-center rounded-full bg-lime-400/15 px-3 py-1 text-xs font-bold text-lime-300 border border-lime-400/20">Opportunity Pemilik Venue</span>
                            <h4 class="mt-2 text-lg font-black text-white">Punya Lapangan? Sewakan di ArenaGo</h4>
                            <p class="mt-1 text-xs leading-relaxed text-indigo-300 max-w-xl">Kelola slot operasional harian, atur tarif per jam, dan terima pesanan masuk otomatis dari ribuan penyewa.</p>
                        </div>
                        <a href="{{ route('owner.register') }}" class="inline-flex shrink-0 items-center justify-center rounded-xl bg-lime-300 px-5 py-3 text-xs font-black text-indigo-950 shadow-md shadow-lime-300/20 hover:bg-lime-200 transition-all">
                            Daftar Jadi Pemilik &rarr;
                        </a>
                    </div>
                </div>
            @endif

        </div>{{-- /container --}}
    </div>{{-- /main content --}}

</x-app-layout>
