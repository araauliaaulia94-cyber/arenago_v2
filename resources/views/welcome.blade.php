<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ArenaGo — Booking Lapangan Olahraga</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-indigo-950 font-sans text-white antialiased">
    <main class="relative isolate min-h-screen overflow-hidden">
        <div class="pointer-events-none absolute -left-32 top-12 h-96 w-96 rounded-full bg-violet-600/20 blur-3xl"></div>
        <div class="pointer-events-none absolute right-0 top-1/4 h-80 w-80 rounded-full bg-indigo-500/20 blur-3xl"></div>
        <div class="pointer-events-none absolute bottom-8 left-1/3 h-48 w-48 rounded-full bg-lime-400/10 blur-3xl"></div>

        <nav class="relative z-10 mx-auto flex max-w-7xl items-center justify-between px-6 py-6 lg:px-8">
            <a href="{{ url('/') }}" class="text-lg font-black tracking-wider text-white">ARENA<span class="text-lime-300">GO</span></a>
            <div class="flex items-center gap-3 text-sm font-semibold">
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-full border border-indigo-400/40 px-4 py-2 text-indigo-100 transition hover:border-lime-300/70 hover:text-lime-300">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="rounded-full border border-indigo-400/40 px-4 py-2 text-indigo-100 transition hover:border-lime-300/70 hover:text-lime-300">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="hidden rounded-full bg-indigo-600 px-4 py-2 text-white shadow-lg shadow-indigo-950/40 transition hover:bg-indigo-500 sm:inline-flex">Daftar</a>
                    @endif
                @endauth
            </div>
        </nav>

        <section class="relative z-10 mx-auto grid max-w-7xl items-center gap-14 px-6 pb-16 pt-16 lg:grid-cols-[1.15fr_.85fr] lg:px-8 lg:pb-24 lg:pt-24">
            <div class="max-w-3xl">
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-lime-300">— Cari lapangan, main sekarang</p>
                <h1 class="mt-6 text-5xl font-black leading-[.98] tracking-tight text-white sm:text-6xl lg:text-7xl">
                    JELAJAHI <span class="text-lime-300">LAPANGAN</span><br>TERBAIK DI KOTAMU
                </h1>
                <p class="mt-7 max-w-2xl text-base leading-7 text-indigo-200 sm:text-lg">
                    Temukan lapangan futsal, basket, badminton, tenis, sampai voli di sekitarmu. Cek ketersediaan secara langsung, bandingkan harga per jam, dan langsung amankan slotnya sebelum diambil orang lain.
                </p>
                <a href="{{ route('fields.index') }}" class="mt-9 inline-flex items-center gap-3 rounded-full bg-indigo-600 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-indigo-950/50 transition duration-200 hover:-translate-y-0.5 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-lime-300 focus:ring-offset-2 focus:ring-offset-indigo-950">
                    Mulai cari lapangan <span class="text-lg leading-none text-lime-300">→</span>
                </a>

                <dl class="mt-12 grid max-w-xl grid-cols-3 gap-5 border-t border-indigo-400/20 pt-7 sm:gap-8">
                    <div>
                        <dt class="text-2xl font-black tracking-tight text-white sm:text-3xl">340<span class="text-lime-300">+</span></dt>
                        <dd class="mt-1 text-xs font-medium leading-5 text-indigo-200">Lapangan mitra</dd>
                    </div>
                    <div>
                        <dt class="text-2xl font-black tracking-tight text-white sm:text-3xl">18</dt>
                        <dd class="mt-1 text-xs font-medium leading-5 text-indigo-200">Kota terjangkau</dd>
                    </div>
                    <div>
                        <dt class="text-2xl font-black tracking-tight text-white sm:text-3xl">4.8<span class="text-lime-300">★</span></dt>
                        <dd class="mt-1 text-xs font-medium leading-5 text-indigo-200">Rating rata-rata</dd>
                    </div>
                </dl>
            </div>

            <div class="relative mx-auto hidden w-full max-w-md lg:block" aria-hidden="true">
                <div class="aspect-square rounded-[2.5rem] border border-indigo-400/20 bg-gradient-to-br from-indigo-800/70 via-indigo-900/40 to-violet-950/70 p-8 shadow-2xl shadow-black/30">
                    <div class="flex h-full flex-col justify-between rounded-[1.75rem] border border-white/10 bg-indigo-950/35 p-7 backdrop-blur-sm">
                        <span class="inline-flex w-fit rounded-full border border-lime-300/30 bg-lime-300/10 px-3 py-1 text-xs font-bold text-lime-300">LIVE AVAILABILITY</span>
                        <div>
                            <p class="text-sm font-semibold text-indigo-200">Lebih dekat ke permainanmu</p>
                            <div class="mt-4 flex items-end gap-3">
                                <span class="text-7xl font-black leading-none text-lime-300">24</span>
                                <span class="pb-1 text-sm font-bold text-white">lapangan<br>tersedia hari ini</span>
                            </div>
                        </div>
                        <div class="h-2 rounded-full bg-indigo-950/80 p-0.5"><div class="h-full w-3/4 rounded-full bg-lime-300 shadow-[0_0_14px_rgba(190,242,100,.65)]"></div></div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
