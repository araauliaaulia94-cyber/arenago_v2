<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-400">Temukan venue olahraga</p>
            <h2 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Cari lapangan untuk bermain</h2>
        </div>
    </x-slot>

    <div class="bg-gradient-to-b from-indigo-50 via-gray-50 to-gray-100 py-8 dark:from-gray-900 dark:via-gray-900 dark:to-gray-950 sm:py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <section class="overflow-hidden rounded-2xl bg-indigo-950 text-white shadow-xl shadow-indigo-950/10">
                <div class="grid gap-6 px-6 py-8 sm:px-8 lg:grid-cols-[1fr_auto] lg:items-end lg:px-10 lg:py-10">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-lime-300">ArenaGo booking</p>
                        <h3 class="mt-3 max-w-xl text-3xl font-bold tracking-tight sm:text-4xl">Temukan lapangan yang tepat. Main tanpa ribet.</h3>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-indigo-200 sm:text-base">Cari berdasarkan lokasi, olahraga, atau anggaran. Pilih jadwal yang tersedia dan lanjutkan booking dalam beberapa langkah.</p>
                    </div>
                    <div class="hidden h-20 w-20 items-center justify-center rounded-2xl bg-white/10 text-4xl backdrop-blur-sm lg:flex">⚽</div>
                </div>
            </section>

            <section class="-mt-2 rounded-2xl bg-white p-5 shadow-xl shadow-indigo-950/10 ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700 sm:-mt-4 sm:p-6">
                <div class="mb-5 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white">Filter pencarian</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Sesuaikan venue dengan kebutuhan permainan Anda.</p>
                    </div>
                    @if(request()->filled('search') || request()->filled('kota') || request()->filled('sport') || request()->filled('min_price') || request()->filled('max_price'))
                        <a href="{{ route('fields.index') }}" class="w-fit text-sm font-semibold text-indigo-600 transition hover:text-indigo-500 dark:text-indigo-400">Reset semua filter</a>
                    @endif
                </div>
                <form method="GET" action="{{ route('fields.index') }}" class="grid gap-4 md:grid-cols-2 xl:grid-cols-[1.35fr_1fr_1fr_0.8fr_0.8fr_auto] xl:items-end">
                    <div>
                        <x-input-label for="search" :value="__('Cari nama lapangan')" class="font-semibold" />
                        <x-text-input id="search" name="search" type="text" class="mt-2 block w-full" :value="request('search')" placeholder="Contoh: Arena Futsal" />
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
                            @foreach($sports as $sport)
                                <option value="{{ $sport }}" @selected(request('sport') == $sport)>{{ $sport }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="min_price" :value="__('Harga minimum')" class="font-semibold" />
                        <div class="mt-2 flex overflow-hidden rounded-lg border border-gray-300 shadow-sm focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500 dark:border-gray-700">
                            <span class="inline-flex items-center border-r border-gray-300 bg-gray-50 px-2 text-xs font-semibold text-gray-500 dark:border-gray-700 dark:bg-gray-900">Rp</span>
                            <input id="min_price" name="min_price" type="number" min="0" step="1000" value="{{ request('min_price') }}" placeholder="0" class="block min-w-0 flex-1 border-0 bg-transparent px-2 py-2.5 text-sm text-gray-900 focus:ring-0 dark:text-white">
                        </div>
                    </div>
                    <div>
                        <x-input-label for="max_price" :value="__('Harga maksimum')" class="font-semibold" />
                        <div class="mt-2 flex overflow-hidden rounded-lg border border-gray-300 shadow-sm focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500 dark:border-gray-700">
                            <span class="inline-flex items-center border-r border-gray-300 bg-gray-50 px-2 text-xs font-semibold text-gray-500 dark:border-gray-700 dark:bg-gray-900">Rp</span>
                            <input id="max_price" name="max_price" type="number" min="0" step="1000" value="{{ request('max_price') }}" placeholder="250000" class="block min-w-0 flex-1 border-0 bg-transparent px-2 py-2.5 text-sm text-gray-900 focus:ring-0 dark:text-white">
                        </div>
                    </div>
                    <x-primary-button class="justify-center rounded-lg bg-indigo-600 px-5 py-3 text-sm normal-case tracking-normal hover:bg-indigo-500">Cari lapangan</x-primary-button>
                </form>
            </section>

            <section class="mt-8 overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                <div class="flex flex-col gap-3 border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:flex-row sm:items-center sm:justify-between sm:px-8">
                    <div class="flex items-center gap-3">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">01</span>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white">Lapangan tersedia</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Pilih venue lalu lihat slot jadwal sebelum booking.</p>
                        </div>
                    </div>
                    <span class="w-fit rounded-full bg-indigo-50 px-3 py-1 text-xs font-bold text-indigo-700 dark:bg-indigo-950/50 dark:text-indigo-300">{{ $fields->total() }} hasil ditemukan</span>
                </div>

                <div class="p-6 sm:p-8">
                    @if($fields->isEmpty())
                        <div class="rounded-2xl border border-dashed border-indigo-200 bg-indigo-50/60 px-6 py-12 text-center dark:border-indigo-900 dark:bg-indigo-950/20">
                            <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-2xl text-indigo-600 shadow-sm dark:bg-gray-800">⌕</span>
                            <h4 class="mt-4 text-lg font-bold text-gray-900 dark:text-white">Belum ada lapangan yang cocok</h4>
                            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500 dark:text-gray-400">Coba ubah kata kunci, lokasi, cabang olahraga, atau rentang harga Anda.</p>
                            <a href="{{ route('fields.index') }}" class="mt-6 inline-flex items-center rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-500">Lihat semua lapangan</a>
                        </div>
                    @else
                        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                            @foreach($fields as $field)
                                @php($rating = $field->reviews->avg('rating'))
                                <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white transition duration-200 hover:-translate-y-1 hover:shadow-xl hover:shadow-indigo-950/10 dark:border-gray-700 dark:bg-gray-900">
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
                                                <p class="mt-1 font-bold text-indigo-700 dark:text-indigo-300">Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}<span class="ml-1 text-xs font-medium text-gray-500">/ jam</span></p>
                                            </div>
                                            <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">Tersedia</span>
                                        </div>
                                        <a href="{{ route('fields.show', $field) }}" class="mt-5 inline-flex w-full items-center justify-center rounded-lg bg-indigo-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-indigo-500">Lihat detail & jadwal <span class="ml-2" aria-hidden="true">&rarr;</span></a>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <div class="mt-8 border-t border-gray-100 pt-6 dark:border-gray-700">
                            {{ $fields->links() }}
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
