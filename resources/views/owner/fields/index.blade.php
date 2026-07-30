<x-app-layout>
    @php
        $availableFields = $fields->where('status', 'available')->count();
        $unavailableFields = $fields->where('status', 'unavailable')->count();
        $totalPhotos = $fields->sum(fn ($field) => $field->photos->count());
    @endphp

    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-400">Owner workspace</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Lapangan saya</h2>
            </div>
            <a href="{{ route('owner.fields.create') }}" class="hidden items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 sm:inline-flex">
                <span class="text-lg leading-none">+</span> Tambah lapangan
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

            <div class="mb-8 flex flex-col gap-5 rounded-2xl bg-indigo-950 p-6 text-white shadow-xl shadow-indigo-950/10 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-lime-300">Ringkasan venue</p>
                    <h3 class="mt-2 text-2xl font-bold">Kelola venue Anda dalam satu tempat.</h3>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-indigo-200">Perbarui detail, galeri, dan slot jadwal setiap lapangan agar penyewa mendapatkan informasi yang selalu akurat.</p>
                </div>
                <a href="{{ route('owner.fields.create') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-lime-300 px-4 py-3 text-sm font-bold text-indigo-950 transition hover:bg-lime-200 sm:hidden">
                    <span class="text-lg leading-none">+</span> Tambah lapangan
                </a>
            </div>

            <section class="mb-8 grid gap-4 sm:grid-cols-3" aria-label="Ringkasan lapangan">
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total lapangan</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $fields->count() }}</p>
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 text-lg text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">⌂</span>
                    </div>
                </div>
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tersedia di katalog</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold tracking-tight text-emerald-600 dark:text-emerald-400">{{ $availableFields }}</p>
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-lg text-emerald-700 dark:bg-emerald-900 dark:text-emerald-200">✓</span>
                    </div>
                </div>
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Foto galeri</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $totalPhotos }}</p>
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-100 text-lg text-violet-700 dark:bg-violet-900 dark:text-violet-200">▧</span>
                    </div>
                </div>
            </section>

            <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                <div class="flex flex-col gap-3 border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:flex-row sm:items-center sm:justify-between sm:px-8">
                    <div class="flex items-center gap-3">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">01</span>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white">Daftar lapangan</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Pilih lapangan untuk memperbarui detail atau mengatur slot booking.</p>
                        </div>
                    </div>
                    @if($unavailableFields > 0)
                        <span class="w-fit rounded-full bg-amber-50 px-3 py-1 text-xs font-bold text-amber-700 dark:bg-amber-950/40 dark:text-amber-300">{{ $unavailableFields }} belum tersedia</span>
                    @endif
                </div>

                <div class="p-6 sm:p-8">
                    @if($fields->isEmpty())
                        <div class="rounded-2xl border border-dashed border-indigo-200 bg-indigo-50/60 px-6 py-12 text-center dark:border-indigo-900 dark:bg-indigo-950/20">
                            <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-2xl text-indigo-600 shadow-sm dark:bg-gray-800">+</span>
                            <h4 class="mt-4 text-lg font-bold text-gray-900 dark:text-white">Belum ada lapangan</h4>
                            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500 dark:text-gray-400">Mulai dengan menambahkan lapangan pertama, lalu buka slot jadwal agar penyewa dapat melakukan booking.</p>
                            <a href="{{ route('owner.fields.create') }}" class="mt-6 inline-flex items-center rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-500">Tambah lapangan pertama</a>
                        </div>
                    @else
                        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                            @foreach($fields as $field)
                                <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white transition duration-200 hover:-translate-y-1 hover:shadow-xl hover:shadow-indigo-950/10 dark:border-gray-700 dark:bg-gray-900">
                                    <div class="relative h-48 overflow-hidden bg-gradient-to-br from-indigo-800 to-violet-700">
                                        @if($field->photos->isNotEmpty())
                                            <img src="{{ Storage::url($field->photos->first()->photo_path) }}" alt="{{ $field->field_name }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                        @else
                                            <span class="flex h-full items-center justify-center text-5xl">⚽</span>
                                        @endif
                                        <div class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-black/55 to-transparent"></div>
                                        <div class="absolute left-4 top-4 flex gap-2">
                                            <span class="rounded-full px-3 py-1.5 text-xs font-bold shadow-sm {{ $field->status === 'available' ? 'bg-lime-300 text-indigo-950' : 'bg-white/90 text-gray-700' }}">{{ $field->status === 'available' ? 'Tersedia' : 'Tidak tersedia' }}</span>
                                        </div>
                                        <span class="absolute bottom-3 right-4 rounded-full bg-black/40 px-2.5 py-1 text-xs font-semibold text-white backdrop-blur-sm">{{ $field->photos->count() }} foto</span>
                                    </div>
                                    <div class="p-5">
                                        <div class="flex gap-3">
                                            <div class="min-w-0 flex-1">
                                                <h4 class="truncate text-lg font-bold text-gray-900 dark:text-white">{{ $field->field_name }}</h4>
                                                <p class="mt-1 truncate text-sm text-gray-500 dark:text-gray-400">{{ $field->sport_category }} · {{ $field->location }}</p>
                                            </div>
                                            <a href="{{ route('fields.show', $field) }}" target="_blank" title="Lihat halaman publik" class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-500 transition hover:bg-indigo-100 hover:text-indigo-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-indigo-950 dark:hover:text-indigo-300" aria-label="Lihat halaman publik {{ $field->field_name }}">↗</a>
                                        </div>
                                        <div class="mt-5 flex items-end justify-between border-t border-gray-100 pt-4 dark:border-gray-800">
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Harga booking</p>
                                                <p class="mt-1 font-bold text-indigo-700 dark:text-indigo-300">Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}<span class="ml-1 text-xs font-medium text-gray-500">/ jam</span></p>
                                            </div>
                                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">{{ $field->photos->count() ? 'Galeri siap' : 'Tambahkan foto' }}</span>
                                        </div>
                                        <div class="mt-5 grid grid-cols-2 gap-2">
                                            <a href="{{ route('owner.fields.edit', $field) }}" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-3 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500">Edit lapangan</a>
                                            <a href="{{ route('owner.schedules.index', $field) }}" class="inline-flex items-center justify-center rounded-lg border border-indigo-200 px-3 py-2.5 text-sm font-semibold text-indigo-700 transition hover:bg-indigo-50 dark:border-indigo-900 dark:text-indigo-300 dark:hover:bg-indigo-950/40">Atur jadwal</a>
                                        </div>
                                        <form method="POST" action="{{ route('owner.fields.destroy', $field) }}" class="mt-3" onsubmit="return confirm('Hapus {{ $field->field_name }} beserta foto dan jadwalnya? Tindakan ini tidak dapat dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full rounded-lg px-3 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-50 dark:hover:bg-red-950/30">Hapus lapangan</button>
                                        </form>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
