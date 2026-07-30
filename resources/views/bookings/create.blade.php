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
        $dayLabel = $dayLabels[$schedule->day] ?? $schedule->day;
    @endphp

    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-400">Booking lapangan</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Konfirmasi jadwal bermain</h2>
            </div>
            <a href="{{ route('fields.show', $schedule->field) }}" class="hidden items-center gap-2 text-sm font-semibold text-gray-600 transition hover:text-indigo-600 dark:text-gray-300 sm:inline-flex">
                <span aria-hidden="true">&larr;</span> Kembali ke detail lapangan
            </a>
        </div>
    </x-slot>

    <div class="bg-gradient-to-b from-indigo-50 via-gray-50 to-gray-100 py-8 dark:from-gray-900 dark:via-gray-900 dark:to-gray-950 sm:py-12">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8" x-data="{
            selectedDate: @js(old('booking_date')),
            validDay: @js($schedule->day),
            selectedDay() {
                return this.selectedDate ? new Intl.DateTimeFormat('en-US', { weekday: 'long' }).format(new Date(this.selectedDate + 'T12:00:00')) : '';
            },
            isCorrectDay() {
                return !this.selectedDate || this.selectedDay() === this.validDay;
            },
            formattedDate() {
                return this.selectedDate ? new Intl.DateTimeFormat('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }).format(new Date(this.selectedDate + 'T12:00:00')) : 'Pilih tanggal bermain';
            }
        }">
            <div class="mb-8 grid gap-4 rounded-2xl bg-indigo-950 p-5 text-white shadow-xl shadow-indigo-950/10 sm:grid-cols-[auto_1fr] sm:items-center sm:p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-lime-300 text-xl font-black text-indigo-950">1</div>
                <div>
                    <p class="font-semibold">Pilih tanggal yang sesuai dengan slot pilihan Anda.</p>
                    <p class="mt-1 text-sm text-indigo-200">Setelah pesanan dibuat, Anda dapat melanjutkan ke tahap pembayaran.</p>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_340px]">
                <form method="POST" action="{{ route('bookings.store') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

                    <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:px-8">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">01</span>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white">Pilih tanggal bermain</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Slot ini tersedia setiap hari {{ $dayLabel }}.</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 sm:p-8">
                            <div class="rounded-xl border border-indigo-100 bg-indigo-50 p-4 dark:border-indigo-900 dark:bg-indigo-950/30">
                                <div class="flex items-start gap-3">
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-indigo-600 text-sm font-bold text-white">{{ strtoupper(substr($dayLabel, 0, 2)) }}</span>
                                    <div>
                                        <p class="font-bold text-indigo-950 dark:text-indigo-100">{{ $dayLabel }}, {{ substr($schedule->start_time, 0, 5) }} – {{ substr($schedule->end_time, 0, 5) }}</p>
                                        <p class="mt-1 text-sm text-indigo-700 dark:text-indigo-300">Pilih tanggal masa kini atau masa depan yang jatuh pada hari {{ $dayLabel }}.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <x-input-label for="booking_date" :value="__('Tanggal booking')" class="font-semibold" />
                                <x-text-input id="booking_date" name="booking_date" type="date" class="mt-2 block w-full text-base" x-model="selectedDate" :min="now()->toDateString()" required />
                                <x-input-error :messages="$errors->get('booking_date')" class="mt-2" />
                            </div>

                            <div x-show="selectedDate" x-cloak :class="isCorrectDay() ? 'border-emerald-200 bg-emerald-50 text-emerald-800 dark:border-emerald-900/60 dark:bg-emerald-950/30 dark:text-emerald-200' : 'border-red-200 bg-red-50 text-red-800 dark:border-red-900/60 dark:bg-red-950/30 dark:text-red-200'" class="mt-5 rounded-xl border p-4">
                                <template x-if="isCorrectDay()">
                                    <div class="flex gap-3">
                                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-xs font-bold text-white">✓</span>
                                        <p class="pt-0.5 text-sm font-medium">Jadwal tersedia untuk <span x-text="formattedDate()" class="font-bold"></span>.</p>
                                    </div>
                                </template>
                                <template x-if="!isCorrectDay()">
                                    <div class="flex gap-3">
                                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-red-600 text-xs font-bold text-white">!</span>
                                        <p class="pt-0.5 text-sm font-medium">Tanggal ini bukan hari {{ $dayLabel }}. Pilih tanggal lain agar sesuai slot.</p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </section>

                    <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:px-8">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">02</span>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white">Sebelum membuat pesanan</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Pesanan dibuat dengan status menunggu pembayaran.</p>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-3 p-6 text-sm text-gray-600 dark:text-gray-300 sm:p-8">
                            <div class="flex gap-3"><span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-xs font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">1</span><p>Pastikan tanggal dan jam yang dipilih sudah sesuai rencana bermain Anda.</p></div>
                            <div class="flex gap-3"><span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-xs font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">2</span><p>Setelah pesanan dibuat, unggah bukti pembayaran untuk dikonfirmasi pemilik lapangan.</p></div>
                        </div>
                    </section>

                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <a href="{{ route('fields.show', $schedule->field) }}" class="inline-flex justify-center rounded-lg px-5 py-3 text-sm font-semibold text-gray-600 transition hover:bg-white hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white">Batalkan</a>
                        <button type="submit" :disabled="!selectedDate || !isCorrectDay()" :class="selectedDate && isCorrectDay() ? 'bg-indigo-600 hover:bg-indigo-500 cursor-pointer' : 'bg-gray-400 cursor-not-allowed'" class="inline-flex justify-center rounded-lg px-6 py-3 text-sm font-semibold text-white transition">Buat pesanan</button>
                    </div>
                </form>

                <aside class="lg:sticky lg:top-6 lg:self-start">
                    <section class="overflow-hidden rounded-2xl bg-indigo-950 text-white shadow-xl shadow-indigo-950/10">
                        <div class="border-b border-white/10 px-6 py-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-lime-300">Ringkasan pesanan</p>
                            <p class="mt-1 text-sm text-indigo-200">Periksa detail sebelum melanjutkan.</p>
                        </div>
                        <div class="p-6">
                            <div class="flex h-32 items-center justify-center overflow-hidden rounded-xl bg-gradient-to-br from-indigo-800 to-violet-700">
                                @if($schedule->field->photos->isNotEmpty())
                                    <img src="{{ Storage::url($schedule->field->photos->first()->photo_path) }}" alt="{{ $schedule->field->field_name }}" class="h-full w-full object-cover">
                                @else
                                    <span class="text-4xl">⚽</span>
                                @endif
                            </div>
                            <div class="mt-5">
                                <p class="text-xl font-bold">{{ $schedule->field->field_name }}</p>
                                <p class="mt-1 text-sm text-indigo-200">{{ $schedule->field->sport_category }} · {{ $schedule->field->location }}</p>
                                <div class="mt-5 space-y-3 border-y border-white/10 py-4 text-sm">
                                    <div class="flex justify-between gap-4"><span class="text-indigo-300">Slot</span><span class="text-right font-bold">{{ $dayLabel }}, {{ substr($schedule->start_time, 0, 5) }} – {{ substr($schedule->end_time, 0, 5) }}</span></div>
                                    <div class="flex justify-between gap-4"><span class="text-indigo-300">Tanggal</span><span x-text="formattedDate()" class="text-right font-bold"></span></div>
                                </div>
                                <div class="mt-5 flex items-end justify-between">
                                    <div>
                                        <p class="text-xs text-indigo-300">Total pembayaran</p>
                                        <p class="mt-1 text-xl font-bold text-lime-300">Rp {{ number_format($schedule->field->price_per_hour, 0, ',', '.') }}</p>
                                    </div>
                                    <span class="rounded-full bg-white/10 px-3 py-1.5 text-xs font-bold text-white">Pending</span>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900 dark:border-amber-900/50 dark:bg-amber-950/30 dark:text-amber-100">
                        <p class="font-bold">Ketersediaan slot</p>
                        <p class="mt-1 text-xs leading-5">Jika slot sudah dipesan lebih dulu, sistem akan memberi tahu Anda sebelum pesanan dibuat.</p>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
