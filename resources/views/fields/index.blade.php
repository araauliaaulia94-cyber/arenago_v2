<x-app-layout>

    {{-- =====================================================================
         HERO AREA — Full-viewport dark hero (fills screen below navbar)
    ====================================================================== --}}
    <div class="relative overflow-hidden bg-indigo-950 min-h-[calc(100vh-4rem)] flex items-center">

        {{-- Ambient Glow Decorations --}}
        <div class="pointer-events-none absolute -right-32 -top-32 h-[500px] w-[500px] rounded-full bg-indigo-700/20 blur-3xl"></div>
        <div class="pointer-events-none absolute -left-20 bottom-0 h-96 w-96 rounded-full bg-violet-700/15 blur-3xl"></div>
        <div class="pointer-events-none absolute right-1/4 top-1/3 h-72 w-72 rounded-full bg-lime-400/8 blur-3xl"></div>

        <div class="relative z-10 mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-0">

            {{-- Hero Content — 2-column on desktop --}}
            <div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between lg:gap-12">

                {{-- Left: Text Content --}}
                <div class="min-w-0 lg:max-w-2xl">

                    {{-- Badge --}}
                    <div class="mb-6 inline-flex items-center gap-2.5 rounded-full border border-indigo-700/60 bg-indigo-900/80 px-4 py-1.5 text-xs font-bold text-lime-300 backdrop-blur-md sm:text-sm">
                        <span class="h-2 w-2 rounded-full bg-lime-400 animate-pulse"></span>
                        TEMUKAN VENUE OLAHRAGA
                    </div>

                    {{-- Main Headline --}}
                    <h1 class="text-4xl font-black tracking-tight text-white leading-[1.1] sm:text-5xl md:text-6xl lg:text-6xl xl:text-7xl">
                        Cari lapangan yang tepat.<br>
                        <span class="text-lime-300">Main tanpa ribet.</span>
                    </h1>

                    {{-- Primary Description --}}
                    <p class="mt-6 text-base font-medium leading-relaxed text-white sm:text-lg md:text-xl max-w-xl">
                        Cari berdasarkan lokasi, olahraga, dan anggaran. Booking dengan mudah di ArenaGo.
                    </p>

                    {{-- Supporting Description --}}
                    <p class="mt-3 text-sm leading-relaxed text-gray-300 sm:text-base max-w-xl">
                        Temukan ratusan venue favorit, cek jadwal secara real-time, dan kunci lapanganmu dalam hitungan detik. Tanpa antre, tanpa ribet.
                    </p>

                    {{-- Statistics --}}
                    <div class="mt-10 flex flex-wrap items-center gap-8 sm:gap-12">
                        <div>
                            <p class="text-3xl font-black text-white sm:text-4xl">500+</p>
                            <p class="mt-1 text-xs font-medium text-gray-300 sm:text-sm">Venue Tersedia</p>
                        </div>
                        <div class="h-10 w-px bg-indigo-700/60"></div>
                        <div>
                            <p class="text-3xl font-black text-white sm:text-4xl">10.000+</p>
                            <p class="mt-1 text-xs font-medium text-gray-300 sm:text-sm">Pengguna Aktif</p>
                        </div>
                        <div class="h-10 w-px bg-indigo-700/60"></div>
                        <div>
                            <p class="text-3xl font-black text-white sm:text-4xl">4.9/5</p>
                            <p class="mt-1 text-xs font-medium text-gray-300 sm:text-sm">Rating Pengguna</p>
                        </div>
                    </div>
                </div>

                {{-- Right: Decorative Ball --}}
                <div class="flex shrink-0 items-center justify-center lg:items-center lg:justify-center lg:pr-8" aria-hidden="true">
                    <span class="hero-ball text-5xl sm:text-6xl lg:text-8xl xl:text-9xl drop-shadow-2xl">⚽</span>
                </div>

            </div>

        </div>{{-- /container --}}
    </div>{{-- /hero area --}}

    {{-- =====================================================================
         MAIN CONTENT AREA — Filter + Results (on indigo-950 bg)
    ====================================================================== --}}
    <div class="bg-indigo-950 pb-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- ── Category Filter Section ── --}}
            <section class="text-center">
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-lime-300">⚽ Pilih Lapangan Favoritmu</p>
                <h2 class="mt-3 text-3xl font-black tracking-tight text-white sm:text-4xl">
                    Lapangan <span class="bg-gradient-to-r from-violet-400 via-fuchsia-400 to-blue-400 bg-clip-text text-transparent">Tersedia</span>
                </h2>
                <p class="mx-auto mt-3 max-w-xl text-sm leading-relaxed text-indigo-300 sm:text-base">
                    Futsal indoor & outdoor, arena pencak silat — semua bisa di-booking instan!
                </p>

                @php
                    $currentSport = request('sport', '');
                    $categories = [
                        '' => ['label' => 'Semua', 'icon' => ''],
                        'Futsal' => ['label' => 'Futsal', 'icon' => '⚽'],
                        'Pencak Silat' => ['label' => 'Pencak Silat', 'icon' => '⚔️'],
                        'Basket' => ['label' => 'Basket', 'icon' => '🏀'],
                        'Badminton' => ['label' => 'Badminton', 'icon' => '🏸'],
                        'Sepak Bola' => ['label' => 'Sepak Bola', 'icon' => '⚽'],
                        'Tenis' => ['label' => 'Tenis', 'icon' => '🎾'],
                        'Voli' => ['label' => 'Voli', 'icon' => '🏐'],
                    ];
                @endphp

                <div class="mt-6 flex flex-wrap justify-center gap-2">
                    @foreach($categories as $key => $cat)
                        @php
                            $params = request()->except('sport', 'page');
                            if ($key !== '') {
                                $params['sport'] = $key;
                            }
                            $isActive = $currentSport === $key || ($key === '' && $currentSport === '');
                        @endphp
                        <a href="{{ route('fields.index', $params) }}"
                           class="inline-flex items-center gap-1.5 rounded-full px-4 py-2 text-xs font-bold transition-all duration-200 sm:text-sm
                                  {{ $isActive
                                      ? 'bg-lime-300 text-indigo-950 shadow-lg shadow-lime-300/20'
                                      : 'border border-white/15 bg-white/8 text-indigo-200 hover:border-lime-400/40 hover:bg-lime-400/10 hover:text-lime-300' }}">
                            @if($cat['icon'])<span>{{ $cat['icon'] }}</span>@endif
                            {{ $cat['label'] }}
                        </a>
                    @endforeach
                </div>
            </section>

            {{-- ── Results Section ── --}}
            @if($fields->isEmpty())
                <div class="rounded-2xl border border-dashed border-indigo-700/50 bg-indigo-950/40 px-6 py-12 text-center">
                    <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-800/50 text-2xl text-indigo-200">⌕</span>
                    <h4 class="mt-4 text-lg font-bold text-white">Belum ada lapangan yang cocok</h4>
                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-indigo-300">Coba ubah kata kunci, lokasi, cabang olahraga, atau rentang harga Anda.</p>
                    <a href="{{ route('fields.index') }}" class="mt-6 inline-flex items-center rounded-xl bg-lime-300 px-5 py-3 text-sm font-bold text-indigo-950 transition hover:bg-lime-200 hover:shadow-lg hover:shadow-lime-300/20">Lihat semua lapangan</a>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach($fields as $field)
                        @php($rating = $field->reviews->avg('rating'))
                        <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white transition duration-300 hover:-translate-y-1 hover:border-indigo-300 hover:shadow-xl hover:shadow-indigo-500/10 dark:border-gray-700 dark:bg-gray-900">
                            <div class="relative h-52 overflow-hidden bg-gradient-to-br from-indigo-800 to-violet-700">
                                @if($field->photos->isNotEmpty())
                                    <img src="{{ Storage::url($field->photos->first()->photo_path) }}" alt="{{ $field->field_name }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                @else
                                    <span class="flex h-full items-center justify-center text-5xl">⚽</span>
                                @endif
                                <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <span class="absolute left-4 top-4 rounded-full bg-white/95 px-3 py-1.5 text-xs font-bold text-indigo-950 shadow-sm">{{ $field->sport_category }}</span>
                                <div class="absolute bottom-3 left-4 flex items-center gap-2 text-xs font-semibold text-white">
                                    <span class="rounded-full bg-black/35 px-2.5 py-1 backdrop-blur-sm">{{ $field->photos->count() }} foto</span>
                                    <span class="rounded-full bg-black/35 px-2.5 py-1 backdrop-blur-sm">{{ $rating ? '★ '.number_format($rating, 1) : 'Baru' }}</span>
                                </div>
                            </div>
                            <div class="p-5">
                                <h4 class="truncate text-lg font-bold text-gray-900 dark:text-white">{{ $field->field_name }}</h4>
                                <p class="mt-1 flex items-center gap-1 truncate text-sm text-gray-500 dark:text-gray-400"><span class="text-indigo-500">●</span> {{ $field->location }}</p>
                                <div class="mt-5 flex items-end justify-between border-t border-gray-100 pt-4 dark:border-gray-800">
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Mulai dari</p>
                                        <p class="mt-1 font-bold text-indigo-700 dark:text-indigo-300">Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}<span class="ml-1 text-xs font-medium text-gray-500 dark:text-gray-400">/ jam</span></p>
                                    </div>
                                    <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">Tersedia</span>
                                </div>
                                <a href="{{ route('fields.show', $field) }}" class="mt-5 inline-flex w-full items-center justify-center rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-indigo-500 hover:shadow-lg hover:shadow-indigo-500/20">Lihat detail & jadwal <span class="ml-2" aria-hidden="true">&rarr;</span></a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-8 border-t border-indigo-800/50 pt-6">
                    {{ $fields->links() }}
                </div>
            @endif

        </div>{{-- /container --}}
    </div>{{-- /main content --}}

</x-app-layout>
