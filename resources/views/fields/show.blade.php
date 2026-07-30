<x-app-layout>
    @php
        $dayLabels = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];
        $primaryPhoto = $field->photos->first();
    @endphp

    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-400">Detail venue</p>
                <h2 class="mt-1 truncate text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $field->field_name }}</h2>
            </div>
            <a href="{{ route('fields.index') }}" class="hidden items-center gap-2 text-sm font-semibold text-gray-600 transition hover:text-indigo-600 dark:text-gray-300 sm:inline-flex">
                <span aria-hidden="true">&larr;</span> Kembali ke katalog
            </a>
        </div>
    </x-slot>

    <div class="bg-gradient-to-b from-indigo-50 via-gray-50 to-gray-100 py-8 dark:from-gray-900 dark:via-gray-900 dark:to-gray-950 sm:py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_360px]">
                <div class="space-y-6">
                    <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700" x-data="{
                        activePhoto: @js($primaryPhoto ? Storage::url($primaryPhoto->photo_path) : null),
                        activeAlt: @js($primaryPhoto ? 'Foto utama '.$field->field_name : 'Belum ada foto lapangan')
                    }">
                        <div class="relative h-72 overflow-hidden bg-gradient-to-br from-indigo-800 to-violet-700 sm:h-[28rem]">
                            @if($primaryPhoto)
                                <img :src="activePhoto" :alt="activeAlt" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full flex-col items-center justify-center text-center text-white">
                                    <span class="text-5xl">⚽</span>
                                    <p class="mt-3 text-sm font-medium text-indigo-100">Foto lapangan belum tersedia</p>
                                </div>
                            @endif
                            <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-black/65 to-transparent"></div>
                            <div class="absolute bottom-5 left-5 right-5 flex flex-wrap items-end justify-between gap-3 text-white sm:bottom-6 sm:left-6 sm:right-6">
                                <div>
                                    <span class="inline-flex rounded-full bg-white/95 px-3 py-1.5 text-xs font-bold text-indigo-950 shadow-sm">{{ $field->sport_category }}</span>
                                    <h1 class="mt-3 text-2xl font-bold tracking-tight sm:text-3xl">{{ $field->field_name }}</h1>
                                    <p class="mt-1 text-sm text-indigo-100">{{ $field->location }}</p>
                                </div>
                                <div class="rounded-xl bg-black/35 px-3 py-2 text-right text-xs font-semibold backdrop-blur-sm">
                                    <p>{{ $field->photos->count() }} foto galeri</p>
                                    <p class="mt-1">{{ $avgRating ? '★ '.number_format($avgRating, 1).' dari '.$field->reviews->count().' ulasan' : 'Belum ada ulasan' }}</p>
                                </div>
                            </div>
                        </div>

                        @if($field->photos->count() > 1)
                            <div class="flex gap-3 overflow-x-auto p-4 sm:p-5">
                                @foreach($field->photos as $photo)
                                    <button type="button" @click="activePhoto = @js(Storage::url($photo->photo_path)); activeAlt = @js('Foto '.($loop->iteration).' '.$field->field_name)" :class="activePhoto === @js(Storage::url($photo->photo_path)) ? 'ring-2 ring-indigo-600 ring-offset-2 dark:ring-offset-gray-800' : 'opacity-70 hover:opacity-100'" class="h-16 w-20 shrink-0 overflow-hidden rounded-lg transition sm:h-20 sm:w-28">
                                        <img src="{{ Storage::url($photo->photo_path) }}" alt="Thumbnail foto {{ $loop->iteration }}" class="h-full w-full object-cover">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </section>

                    <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:px-8">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">01</span>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white">Tentang lapangan</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Informasi dari pemilik venue.</p>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-6 p-6 sm:p-8">
                            <p class="whitespace-pre-line text-sm leading-7 text-gray-600 dark:text-gray-300">{{ $field->description ?: 'Pemilik belum menambahkan deskripsi untuk lapangan ini.' }}</p>
                            <div class="grid gap-4 border-t border-gray-100 pt-6 dark:border-gray-700 sm:grid-cols-2">
                                <div class="rounded-xl bg-indigo-50 p-4 dark:bg-indigo-950/30">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-indigo-600 dark:text-indigo-300">Lokasi</p>
                                    <p class="mt-2 font-bold text-gray-900 dark:text-white">{{ $field->location }}</p>
                                </div>
                                <div class="rounded-xl bg-indigo-50 p-4 dark:bg-indigo-950/30">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-indigo-600 dark:text-indigo-300">Kategori</p>
                                    <p class="mt-2 font-bold text-gray-900 dark:text-white">{{ $field->sport_category }}</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:px-8">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">02</span>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white">Ulasan penyewa</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $avgRating ? 'Rata-rata rating '.number_format($avgRating, 1).' dari '.$field->reviews->count().' ulasan.' : 'Belum ada ulasan untuk venue ini.' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 sm:p-8">
                            @if($field->reviews->isEmpty())
                                <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-5 py-8 text-center text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-400">
                                    Ulasan akan tampil setelah penyewa menyelesaikan booking. Fitur pemberian ulasan diselesaikan pada Fase 4.
                                </div>
                            @else
                                <div class="space-y-5">
                                    @foreach($field->reviews as $review)
                                        <article class="border-b border-gray-100 pb-5 last:border-0 last:pb-0 dark:border-gray-700">
                                            <div class="flex items-start justify-between gap-4">
                                                <div class="flex items-center gap-3">
                                                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">{{ strtoupper(substr($review->user->name, 0, 1)) }}</span>
                                                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $review->user->name }}</p>
                                                </div>
                                                <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-700 dark:bg-amber-950/40 dark:text-amber-300">★ {{ $review->rating }}</span>
                                            </div>
                                            <p class="mt-3 text-sm leading-6 text-gray-600 dark:text-gray-300">{{ $review->comment }}</p>
                                        </article>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </section>
                </div>

                <aside class="lg:sticky lg:top-6 lg:self-start">
                    <section class="overflow-hidden rounded-2xl bg-indigo-950 text-white shadow-xl shadow-indigo-950/10">
                        <div class="border-b border-white/10 px-6 py-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-lime-300">Booking lapangan</p>
                            <h3 class="mt-1 text-xl font-bold">Pilih slot bermain</h3>
                        </div>
                        <div class="p-6">
                            <div class="flex items-end justify-between border-b border-white/10 pb-5">
                                <div>
                                    <p class="text-xs text-indigo-300">Harga mulai dari</p>
                                    <p class="mt-1 text-2xl font-bold text-lime-300">Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}</p>
                                    <p class="text-xs text-indigo-300">per jam</p>
                                </div>
                                <span class="rounded-full bg-lime-300 px-3 py-1.5 text-xs font-bold text-indigo-950">Tersedia</span>
                            </div>

                            <div class="mt-6">
                                <p class="text-sm font-bold">Slot operasional</p>
                                <p class="mt-1 text-xs leading-5 text-indigo-200">Pilih jam, lalu tentukan tanggal yang sesuai pada tahap booking.</p>
                                @if($field->schedules->isEmpty())
                                    <div class="mt-4 rounded-xl border border-white/10 bg-white/5 p-4 text-center text-sm text-indigo-200">
                                        Pemilik belum membuka slot booking.
                                    </div>
                                @else
                                    <div class="mt-4 space-y-4">
                                        @foreach($dayLabels as $day => $label)
                                            @php($daySchedules = $field->schedules->where('day', $day))
                                            @if($daySchedules->isNotEmpty())
                                                <div>
                                                    <p class="text-xs font-bold uppercase tracking-wide text-indigo-300">{{ $label }}</p>
                                                    <div class="mt-2 grid grid-cols-2 gap-2">
                                                        @foreach($daySchedules as $schedule)
                                                            <a href="{{ route('bookings.create', $schedule) }}" class="rounded-lg bg-white/10 px-2 py-2.5 text-center text-xs font-bold text-white transition hover:bg-lime-300 hover:text-indigo-950">
                                                                {{ substr($schedule->start_time, 0, 5) }} – {{ substr($schedule->end_time, 0, 5) }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </section>

                    <section class="mt-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-indigo-600 dark:text-indigo-300">Dikelola oleh</p>
                        <div class="mt-3 flex items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-100 text-lg font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">{{ strtoupper(substr($field->owner->nama_usaha, 0, 1)) }}</span>
                            <div class="min-w-0">
                                <p class="truncate font-bold text-gray-900 dark:text-white">{{ $field->owner->nama_usaha }}</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">{{ $field->owner->kota }}</p>
                            </div>
                        </div>
                    </section>

                    <a href="{{ route('fields.index') }}" class="mt-4 flex items-center justify-between rounded-xl border border-indigo-100 bg-white px-4 py-3 text-sm font-semibold text-indigo-700 shadow-sm transition hover:bg-indigo-50 dark:border-gray-700 dark:bg-gray-800 dark:text-indigo-300 dark:hover:bg-gray-700">
                        Lihat lapangan lainnya <span aria-hidden="true">&rarr;</span>
                    </a>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
