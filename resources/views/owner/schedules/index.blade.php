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
    @endphp

    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-400">Owner workspace</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Atur jadwal slot</h2>
            </div>
            <a href="{{ route('owner.fields.edit', $field) }}" class="hidden items-center gap-2 text-sm font-semibold text-gray-600 transition hover:text-indigo-600 dark:text-gray-300 sm:inline-flex">
                <span aria-hidden="true">&larr;</span> Kembali ke edit lapangan
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

            <div class="mb-8 grid gap-4 rounded-2xl bg-indigo-950 p-5 text-white shadow-xl shadow-indigo-950/10 sm:grid-cols-[auto_1fr] sm:items-center sm:p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-lime-300 text-xl font-black text-indigo-950">2</div>
                <div>
                    <p class="font-semibold">Tentukan jam operasional yang dapat dipesan setiap minggu.</p>
                    <p class="mt-1 text-sm text-indigo-200">Setiap slot adalah template mingguan. Penyewa memilih tanggal yang sesuai dengan hari slot saat membuat booking.</p>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">
                <div class="space-y-6">
                    <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:px-8">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">01</span>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white">Tambah slot operasional</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Contoh: Senin, 19.00 sampai 20.00.</p>
                                </div>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('owner.schedules.store', $field) }}" class="grid gap-5 p-6 sm:grid-cols-2 sm:p-8 lg:grid-cols-[1.2fr_1fr_1fr_auto] lg:items-end">
                            @csrf
                            <div>
                                <x-input-label for="day" :value="__('Hari operasional')" class="font-semibold" />
                                <select id="day" name="day" class="mt-2 block w-full rounded-lg border-gray-300 py-2.5 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200" required>
                                    @foreach($dayLabels as $day => $label)
                                        <option value="{{ $day }}" @selected(old('day', 'Monday') === $day)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('day')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="start_time" :value="__('Jam mulai')" class="font-semibold" />
                                <x-text-input id="start_time" type="time" name="start_time" class="mt-2 block w-full" :value="old('start_time')" required />
                                <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="end_time" :value="__('Jam selesai')" class="font-semibold" />
                                <x-text-input id="end_time" type="time" name="end_time" class="mt-2 block w-full" :value="old('end_time')" required />
                                <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                            </div>
                            <x-primary-button class="justify-center rounded-lg bg-indigo-600 px-5 py-3 text-sm normal-case tracking-normal hover:bg-indigo-500">Tambah slot</x-primary-button>
                        </form>
                    </section>

                    <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="flex flex-col gap-3 border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:flex-row sm:items-center sm:justify-between sm:px-8">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">02</span>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white">Slot yang sudah dibuka</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Hapus slot yang tidak lagi tersedia untuk booking.</p>
                                </div>
                            </div>
                            <span class="w-fit rounded-full bg-indigo-50 px-3 py-1 text-xs font-bold text-indigo-700 dark:bg-indigo-950/50 dark:text-indigo-300">{{ $schedules->count() }} slot</span>
                        </div>
                        <div class="p-6 sm:p-8">
                            @if($schedules->isEmpty())
                                <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 py-10 text-center dark:border-gray-700 dark:bg-gray-900/50">
                                    <span class="text-3xl">🗓</span>
                                    <p class="mt-3 font-semibold text-gray-800 dark:text-gray-200">Belum ada slot operasional</p>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Tambahkan slot pertama menggunakan form di atas.</p>
                                </div>
                            @else
                                <div class="space-y-3">
                                    @foreach($schedules as $schedule)
                                        <article class="flex flex-col gap-4 rounded-xl border border-gray-200 bg-gray-50 p-4 transition hover:border-indigo-200 hover:bg-indigo-50/40 dark:border-gray-700 dark:bg-gray-900/50 dark:hover:border-indigo-800 dark:hover:bg-indigo-950/20 sm:flex-row sm:items-center sm:justify-between">
                                            <div class="flex items-center gap-4">
                                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">{{ strtoupper(substr($dayLabels[$schedule->day] ?? $schedule->day, 0, 2)) }}</div>
                                                <div>
                                                    <p class="font-bold text-gray-900 dark:text-white">{{ $dayLabels[$schedule->day] ?? $schedule->day }}</p>
                                                    <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Slot berulang setiap minggu</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center justify-between gap-4 sm:justify-end">
                                                <p class="rounded-lg bg-white px-3 py-2 text-sm font-bold text-indigo-700 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:text-indigo-300 dark:ring-gray-700">{{ substr($schedule->start_time, 0, 5) }} – {{ substr($schedule->end_time, 0, 5) }}</p>
                                                <form method="POST" action="{{ route('owner.schedules.destroy', [$field, $schedule]) }}" onsubmit="return confirm('Hapus slot {{ $dayLabels[$schedule->day] ?? $schedule->day }} pukul {{ substr($schedule->start_time, 0, 5) }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="rounded-lg border border-red-200 px-3 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-50 dark:border-red-900/60 dark:hover:bg-red-950/30">Hapus</button>
                                                </form>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </section>
                </div>

                <aside class="lg:sticky lg:top-6 lg:self-start">
                    <div class="overflow-hidden rounded-2xl bg-indigo-950 text-white shadow-xl shadow-indigo-950/10">
                        <div class="border-b border-white/10 px-6 py-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-lime-300">Lapangan yang dikelola</p>
                            <p class="mt-1 text-sm text-indigo-200">Ringkasan venue untuk jadwal ini.</p>
                        </div>
                        <div class="p-6">
                            <div class="flex h-36 items-center justify-center overflow-hidden rounded-xl bg-gradient-to-br from-indigo-800 to-violet-700">
                                @if($field->photos->isNotEmpty())
                                    <img src="{{ Storage::url($field->photos->first()->photo_path) }}" alt="{{ $field->field_name }}" class="h-full w-full object-cover">
                                @else
                                    <span class="text-4xl">⚽</span>
                                @endif
                            </div>
                            <div class="mt-5">
                                <p class="text-xl font-bold">{{ $field->field_name }}</p>
                                <p class="mt-1 text-sm text-indigo-200">{{ $field->sport_category }} · {{ $field->location }}</p>
                                <div class="mt-5 flex items-end justify-between border-t border-white/10 pt-4">
                                    <div>
                                        <p class="text-xs text-indigo-300">Harga booking</p>
                                        <p class="mt-1 font-bold text-lime-300">Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}</p>
                                        <p class="text-xs text-indigo-300">per jam</p>
                                    </div>
                                    <span class="rounded-full px-3 py-1.5 text-xs font-bold {{ $field->status === 'available' ? 'bg-lime-300 text-indigo-950' : 'bg-white/15 text-white' }}">{{ $field->status === 'available' ? 'Tersedia' : 'Tidak tersedia' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900 dark:border-amber-900/50 dark:bg-amber-950/30 dark:text-amber-100">
                        <p class="font-bold">Tips pengaturan slot</p>
                        <p class="mt-1 text-xs leading-5">Buat slot per jam sesuai operasional. Penyewa hanya dapat booking pada hari dan jam yang Anda buka.</p>
                    </div>
                    <a href="{{ route('owner.fields.edit', $field) }}" class="mt-4 flex items-center justify-between rounded-xl border border-indigo-100 bg-white px-4 py-3 text-sm font-semibold text-indigo-700 shadow-sm transition hover:bg-indigo-50 dark:border-gray-700 dark:bg-gray-800 dark:text-indigo-300 dark:hover:bg-gray-700">
                        Edit detail lapangan <span aria-hidden="true">&rarr;</span>
                    </a>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
