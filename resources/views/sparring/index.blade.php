<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-400">Komunitas & Matchmaking</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Cari lawan & jadwal sparring</h2>
            </div>
            <a href="{{ route('sparring.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500 shadow-sm">
                + Buat Post Sparring
            </a>
        </div>
    </x-slot>

    <div class="bg-gradient-to-b from-indigo-50 via-gray-50 to-gray-100 py-8 dark:from-gray-900 dark:via-gray-900 dark:to-gray-950 sm:py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 shadow-sm dark:border-emerald-900/60 dark:bg-emerald-950/30 dark:text-emerald-200">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-xs font-bold text-white">✓</span>
                    <p class="pt-0.5 font-medium">{{ session('status') }}</p>
                </div>
            @endif

            <!-- Hero Banner -->
            <section class="overflow-hidden rounded-2xl bg-indigo-950 text-white shadow-xl shadow-indigo-950/10">
                <div class="grid gap-6 px-6 py-8 sm:px-8 lg:grid-cols-[1fr_auto] lg:items-end lg:px-10 lg:py-10">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-lime-300">ArenaGo Matchmaking</p>
                        <h3 class="mt-3 max-w-xl text-3xl font-bold tracking-tight sm:text-4xl">Temukan lawan sparring sepadan di kotamu.</h3>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-indigo-200 sm:text-base">Filter berdasarkan kota, cabang olahraga, atau tanggal. Tantang tim lain dan adu kemampuan di lapangan.</p>
                    </div>
                    <div class="hidden h-20 w-20 items-center justify-center rounded-2xl bg-white/10 text-4xl backdrop-blur-sm lg:flex">⚔️</div>
                </div>
            </section>

            <!-- Filter Section -->
            <section class="-mt-2 rounded-2xl bg-white p-5 shadow-xl shadow-indigo-950/10 ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700 sm:-mt-4 sm:p-6">
                <div class="mb-5 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white">Filter pencarian sparring</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Cari ajakan bertanding yang sesuai dengan jadwal tim Anda.</p>
                    </div>
                    @if(request()->filled('search') || request()->filled('kota') || request()->filled('sport') || request()->filled('tanggal') || request()->filled('status'))
                        <a href="{{ route('sparring.index') }}" class="w-fit text-sm font-semibold text-indigo-600 transition hover:text-indigo-500 dark:text-indigo-400">Reset semua filter</a>
                    @endif
                </div>
                <form method="GET" action="{{ route('sparring.index') }}" class="grid gap-4 md:grid-cols-2 xl:grid-cols-[1.2fr_1fr_1fr_1fr_0.9fr_auto] xl:items-end">
                    <div>
                        <x-input-label for="search" :value="__('Cari judul / tim')" class="font-semibold" />
                        <x-text-input id="search" name="search" type="text" class="mt-2 block w-full" :value="request('search')" placeholder="Contoh: Garuda Futsal" />
                    </div>
                    <div>
                        <x-input-label for="kota" :value="__('Kota / lokasi')" class="font-semibold" />
                        <select id="kota" name="kota" class="mt-2 block w-full rounded-lg border-gray-300 py-2.5 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
                            <option value="">Semua kota</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" @selected(request('kota') == $city)>{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="sport" :value="__('Cabang olahraga')" class="font-semibold" />
                        <select id="sport" name="sport" class="mt-2 block w-full rounded-lg border-gray-300 py-2.5 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
                            <option value="">Semua olahraga</option>
                            @foreach(['Futsal', 'Badminton', 'Basket', 'Mini Soccer', 'Voli', 'Tenis'] as $sportOption)
                                <option value="{{ $sportOption }}" @selected(request('sport') == $sportOption)>{{ $sportOption }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="tanggal" :value="__('Tanggal tanding')" class="font-semibold" />
                        <x-text-input id="tanggal" name="tanggal" type="date" class="mt-2 block w-full" :value="request('tanggal')" />
                    </div>
                    <div>
                        <x-input-label for="status" :value="__('Status post')" class="font-semibold" />
                        <select id="status" name="status" class="mt-2 block w-full rounded-lg border-gray-300 py-2.5 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
                            <option value="" @selected(request('status') === null || request('status') === '')>Aktif (Open/Matched)</option>
                            <option value="open" @selected(request('status') == 'open')>Open (Mencari Lawan)</option>
                            <option value="matched" @selected(request('status') == 'matched')>Matched (Sudah Dapat Lawan)</option>
                            <option value="all" @selected(request('status') == 'all')>Semua Status</option>
                        </select>
                    </div>
                    <x-primary-button class="justify-center rounded-lg bg-indigo-600 px-5 py-3 text-sm normal-case tracking-normal hover:bg-indigo-500">Cari sparring</x-primary-button>
                </form>
            </section>

            <!-- Results Section -->
            <section class="mt-8 overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                <div class="flex flex-col gap-3 border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:flex-row sm:items-center sm:justify-between sm:px-8">
                    <div class="flex items-center gap-3">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">⚔️</span>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white">Jadwal Sparring Aktif</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Temukan tim lawan dan ajukan tantangan sparring.</p>
                        </div>
                    </div>
                    <span class="w-fit rounded-full bg-indigo-50 px-3 py-1 text-xs font-bold text-indigo-700 dark:bg-indigo-950/50 dark:text-indigo-300">
                        {{ $posts->total() }} postingan ditemukan
                    </span>
                </div>

                <div class="p-6 sm:p-8">
                    @if($posts->isEmpty())
                        <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 py-12 text-center dark:border-gray-700 dark:bg-gray-900/50">
                            <span class="text-4xl">⚽</span>
                            <p class="mt-3 font-semibold text-gray-800 dark:text-gray-200">Tidak ada postingan sparring yang sesuai</p>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Coba ubah kata kunci filter atau buat ajakan sparring baru milik tim Anda.</p>
                            <a href="{{ route('sparring.create') }}" class="mt-5 inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500">
                                + Buat Post Sparring Baru
                            </a>
                        </div>
                    @else
                        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($posts as $post)
                                <article class="flex flex-col justify-between overflow-hidden rounded-2xl border border-gray-200 bg-gray-50/50 p-5 transition hover:border-indigo-200 hover:bg-indigo-50/20 dark:border-gray-700 dark:bg-gray-900/50 dark:hover:border-indigo-800 dark:hover:bg-indigo-950/20">
                                    <div>
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200 uppercase">
                                                {{ $post->sport_category }}
                                            </span>
                                            <span class="rounded-full px-2.5 py-0.5 text-xs font-bold uppercase {{ $post->status === 'open' ? 'bg-emerald-500/15 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-500/30' : 'bg-amber-500/15 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300 border border-amber-500/30' }}">
                                                {{ $post->status === 'open' ? 'OPEN' : 'MATCHED' }}
                                            </span>
                                        </div>

                                        <h4 class="mt-3 text-lg font-bold text-gray-900 dark:text-white leading-snug">
                                            {{ $post->title }}
                                        </h4>
                                        <p class="mt-1 text-xs font-semibold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">
                                            Host: {{ $post->team_name }} ({{ $post->user->name }})
                                        </p>

                                        <div class="mt-4 space-y-2 rounded-xl bg-white p-3.5 text-xs shadow-sm dark:bg-gray-800 text-gray-600 dark:text-gray-300 ring-1 ring-gray-200 dark:ring-gray-700">
                                            <div class="flex justify-between">
                                                <span class="text-gray-500 dark:text-gray-400">📍 Lokasi:</span>
                                                <span class="font-bold text-gray-900 dark:text-white">{{ $post->location }}</span>
                                            </div>
                                            @if($post->field)
                                                <div class="flex justify-between">
                                                    <span class="text-gray-500 dark:text-gray-400">🏟 Venue:</span>
                                                    <span class="font-bold text-gray-900 dark:text-white truncate max-w-[160px]">{{ $post->field->field_name }}</span>
                                                </div>
                                            @endif
                                            <div class="flex justify-between">
                                                <span class="text-gray-500 dark:text-gray-400">📅 Tanggal:</span>
                                                <span class="font-bold text-gray-900 dark:text-white">{{ $post->event_date->format('d M Y') }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-500 dark:text-gray-400">⏰ Jam:</span>
                                                <span class="font-bold text-gray-900 dark:text-white">{{ substr($post->start_time, 0, 5) }} – {{ substr($post->end_time, 0, 5) }}</span>
                                            </div>
                                            @if($post->cost)
                                                <div class="flex justify-between border-t border-gray-100 dark:border-gray-700 pt-2">
                                                    <span class="text-gray-500 dark:text-gray-400">💰 Biaya:</span>
                                                    <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $post->cost }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mt-5 border-t border-gray-100 dark:border-gray-700/60 pt-4 flex items-center justify-between">
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            <span>Kontak:</span>
                                            <span class="font-semibold text-gray-800 dark:text-gray-200 block">{{ $post->contact }}</span>
                                        </div>
                                        <a href="{{ route('sparring.show', $post) }}" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-3.5 py-2 text-xs font-bold text-white transition hover:bg-indigo-500 shadow-sm">
                                            Detail & Tantang &rarr;
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $posts->links() }}
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
