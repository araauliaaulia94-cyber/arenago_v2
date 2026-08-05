<x-app-layout>
    @php
        $dayLabels = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu',
        ];
        $scheduleDay = $dayLabels[$booking->schedule->day] ?? $booking->schedule->day;
        $field = $booking->schedule->field;
        $primaryPhoto = $field->photos->first();
        $paymentMethods = [
            'bank_transfer' => ['label' => 'Transfer Bank', 'hint' => 'Transfer manual ke rekening pemilik, lalu unggah bukti transfer.'],
            'qris' => ['label' => 'QRIS', 'hint' => 'Pindai kode QRIS pemilik lapangan, lalu unggah screenshot bukti pembayaran.'],
            'e_wallet' => ['label' => 'E-Wallet', 'hint' => 'Bayar via e-wallet (GoPay, OVO, DANA, dll), lalu unggah bukti transfer.'],
        ];
    @endphp

    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-400">Pembayaran pesanan</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Selesaikan pembayaran booking</h2>
            </div>
            <a href="{{ route('bookings.show', $booking) }}" class="hidden items-center gap-2 text-sm font-semibold text-gray-600 transition hover:text-indigo-600 dark:text-gray-300 sm:inline-flex">
                <span aria-hidden="true">&larr;</span> Kembali ke detail pesanan
            </a>
        </div>
    </x-slot>

    <div class="bg-gradient-to-b from-indigo-50 via-gray-50 to-gray-100 py-8 dark:from-gray-900 dark:via-gray-900 dark:to-gray-950 sm:py-12">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8" x-data="{
            method: @js(old('payment_method', 'bank_transfer')),
            fileName: '',
            filePreview: null,
            pickFile(event) {
                const file = event.target.files[0];
                this.fileName = file ? file.name : '';
                this.filePreview = file ? URL.createObjectURL(file) : null;
            },
            methodLabel() {
                const labels = { bank_transfer: 'Transfer Bank', qris: 'QRIS', e_wallet: 'E-Wallet' };
                return labels[this.method] || 'Metode pembayaran';
            }
        }">
            <div class="mb-8 grid gap-4 rounded-2xl bg-indigo-950 p-5 text-white shadow-xl shadow-indigo-950/10 sm:grid-cols-[auto_1fr] sm:items-center sm:p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-lime-300 text-xl font-black text-indigo-950">&#128179;</div>
                <div>
                    <p class="font-semibold">Pilih metode pembayaran dan unggah bukti transfer.</p>
                    <p class="mt-1 text-sm text-indigo-200">Pemilik lapangan akan memverifikasi bukti pembayaran Anda sebelum pesanan ditandai lunas.</p>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_340px]">
                <form method="POST" action="{{ route('payments.store', $booking) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:px-8">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">01</span>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white">Pilih metode pembayaran</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Metode menentukan instruksi transfer dari pemilik lapangan.</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 sm:p-8">
                            <div class="grid gap-3 sm:grid-cols-3">
                                @foreach($paymentMethods as $value => $meta)
                                    <label :class="method === '{{ $value }}' ? 'border-indigo-600 bg-indigo-50 ring-2 ring-indigo-600 dark:bg-indigo-950/40 dark:border-indigo-500 dark:ring-indigo-500' : 'border-gray-200 hover:border-indigo-300 hover:bg-indigo-50/40 dark:border-gray-700 dark:hover:border-indigo-800 dark:hover:bg-indigo-950/20'" class="cursor-pointer rounded-xl border p-4 transition">
                                        <input type="radio" name="payment_method" value="{{ $value }}" x-model="method" @checked(old('payment_method', 'bank_transfer') === $value) class="sr-only">
                                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $meta['label'] }}</p>
                                        <p class="mt-1 text-xs leading-5 text-gray-500 dark:text-gray-400">{{ $meta['hint'] }}</p>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('payment_method')" class="mt-3" />
                        </div>
                    </section>

                    <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:px-8">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">02</span>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white">Unggah bukti pembayaran</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">JPG atau PNG, maksimal 2 MB.</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 sm:p-8">
                            <label for="payment_proof" class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-indigo-200 bg-indigo-50/60 px-6 py-10 text-center transition hover:border-indigo-500 hover:bg-indigo-50 dark:border-indigo-900 dark:bg-indigo-950/30 dark:hover:bg-indigo-950/50">
                                <span class="flex h-11 w-11 items-center justify-center rounded-full bg-white text-xl text-indigo-600 shadow-sm dark:bg-gray-800">&#8533;</span>
                                <span class="mt-3 text-sm font-bold text-indigo-700 dark:text-indigo-300">Pilih file bukti pembayaran</span>
                                <span class="mt-1 text-xs text-gray-500 dark:text-gray-400">Klik untuk memilih screenshot atau foto bukti transfer</span>
                            </label>
                            <input id="payment_proof" type="file" name="payment_proof" accept="image/*" required class="sr-only" @change="pickFile($event)">
                            <x-input-error :messages="$errors->get('payment_proof')" class="mt-3" />

                            <div x-show="fileName" x-cloak class="mt-5 rounded-xl border border-gray-100 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900/50">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="truncate text-sm font-bold text-gray-800 dark:text-gray-200" x-text="fileName"></p>
                                    <span class="shrink-0 rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-bold text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-300">&#10003; Siap</span>
                                </div>
                                <template x-if="filePreview">
                                    <img :src="filePreview" alt="Pratinjau bukti pembayaran" class="mt-3 h-40 w-full rounded-lg object-cover ring-1 ring-gray-200 dark:ring-gray-700">
                                </template>
                            </div>
                        </div>
                    </section>

                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <a href="{{ route('bookings.show', $booking) }}" class="inline-flex justify-center rounded-lg px-5 py-3 text-sm font-semibold text-gray-600 transition hover:bg-white hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white">Nanti saja</a>
                        <button type="submit" :disabled="!fileName" :class="fileName ? 'bg-indigo-600 hover:bg-indigo-500 cursor-pointer' : 'bg-gray-400 cursor-not-allowed'" class="inline-flex justify-center rounded-lg px-6 py-3 text-sm font-semibold text-white transition">
                            <span aria-hidden="true">&rarr;</span> Unggah bukti pembayaran
                        </button>
                    </div>
                </form>

                <aside class="lg:sticky lg:top-6 lg:self-start">
                    <section class="overflow-hidden rounded-2xl bg-indigo-950 text-white shadow-xl shadow-indigo-950/10">
                        <div class="border-b border-white/10 px-6 py-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-lime-300">Ringkasan tagihan</p>
                            <p class="mt-1 text-sm text-indigo-200">Periksa detail sebelum mengunggah bukti.</p>
                        </div>
                        <div class="p-6">
                            <div class="flex h-32 items-center justify-center overflow-hidden rounded-xl bg-gradient-to-br from-indigo-800 to-violet-700">
                                @if($primaryPhoto)
                                    <img src="{{ Storage::url($primaryPhoto->photo_path) }}" alt="{{ $field->field_name }}" class="h-full w-full object-cover">
                                @else
                                    <span class="text-4xl">&#9917;</span>
                                @endif
                            </div>
                            <div class="mt-5">
                                <p class="text-xl font-bold">{{ $field->field_name }}</p>
                                <p class="mt-1 text-sm text-indigo-200">{{ $field->sport_category }} &middot; {{ $field->location }}</p>
                                <div class="mt-5 space-y-3 border-y border-white/10 py-4 text-sm">
                                    <div class="flex justify-between gap-4"><span class="text-indigo-300">Tanggal main</span><span class="text-right font-bold">{{ $scheduleDay }}, {{ $booking->booking_date->format('j M Y') }}</span></div>
                                    <div class="flex justify-between gap-4"><span class="text-indigo-300">Jam slot</span><span class="text-right font-bold">{{ substr($booking->schedule->start_time, 0, 5) }} &ndash; {{ substr($booking->schedule->end_time, 0, 5) }}</span></div>
                                    <div class="flex justify-between gap-4"><span class="text-indigo-300">Metode</span><span class="text-right font-bold" x-text="methodLabel()"></span></div>
                                </div>
                                <div class="mt-5 flex items-end justify-between">
                                    <div>
                                        <p class="text-xs text-indigo-300">Total tagihan</p>
                                        <p class="mt-1 text-xl font-bold text-lime-300">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                    </div>
                                    <span class="rounded-full bg-white/10 px-3 py-1.5 text-xs font-bold text-white">Menunggu bukti</span>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900 dark:border-amber-900/50 dark:bg-amber-950/30 dark:text-amber-100">
                        <p class="font-bold">Tips verifikasi</p>
                        <p class="mt-1 text-xs leading-5">Pastikan nominal pada bukti pembayaran sesuai dengan total tagihan. Pemilik akan mengonfirmasi setelah bukti diverifikasi.</p>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
