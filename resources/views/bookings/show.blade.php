<x-app-layout>
    @php
        $dayLabels = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu',
        ];
        $monthLabels = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
        $paymentMethodLabels = [
            'bank_transfer' => 'Transfer Bank',
            'qris' => 'QRIS',
            'e_wallet' => 'E-Wallet',
        ];
        $paymentStatusLabels = [
            'pending' => 'Menunggu konfirmasi pemilik',
            'successful' => 'Pembayaran berhasil',
            'failed' => 'Pembayaran gagal',
            'refunded' => 'Pembayaran dikembalikan',
        ];

        $scheduleDay = $dayLabels[$booking->schedule->day] ?? $booking->schedule->day;
        $dateLabel = $scheduleDay . ', ' . $booking->booking_date->format('j') . ' ' . ($monthLabels[$booking->booking_date->month] ?? '') . ' ' . $booking->booking_date->year;
        $field = $booking->schedule->field;
        $primaryPhoto = $field->photos->first();

        // Status ramah pengguna untuk booking
        if ($booking->status === 'paid') {
            $badge = ['label' => 'Lunas', 'class' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/50 dark:text-emerald-300'];
        } elseif ($booking->status === 'cancelled') {
            $badge = ['label' => 'Dibatalkan', 'class' => 'bg-red-100 text-red-800 dark:bg-red-950/50 dark:text-red-300'];
        } elseif ($booking->status === 'pending' && $booking->payment) {
            $badge = ['label' => 'Menunggu konfirmasi', 'class' => 'bg-amber-100 text-amber-800 dark:bg-amber-950/50 dark:text-amber-300'];
        } else {
            $badge = ['label' => 'Menunggu pembayaran', 'class' => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300'];
        }

        $canPay = !$booking->payment && $booking->status === 'pending';
        $waitingConfirm = $booking->payment && $booking->payment->status === 'pending' && $booking->status === 'pending';
        $isPaid = $booking->status === 'paid';
        $canCancel = $booking->status === 'pending';
    @endphp

    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-400">Pesanan saya</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Detail pesanan</h2>
            </div>
            <a href="{{ route('bookings.index') }}" class="hidden items-center gap-2 text-sm font-semibold text-gray-600 transition hover:text-indigo-600 dark:text-gray-300 sm:inline-flex">
                <span aria-hidden="true">&larr;</span> Kembali ke pesanan saya
            </a>
        </div>
    </x-slot>

    <div class="bg-gradient-to-b from-indigo-50 via-gray-50 to-gray-100 py-8 dark:from-gray-900 dark:via-gray-900 dark:to-gray-950 sm:py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 shadow-sm dark:border-emerald-900/60 dark:bg-emerald-950/30 dark:text-emerald-200">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-xs font-bold text-white">&#10003;</span>
                    <p class="pt-0.5 font-medium">{{ session('status') }}</p>
                </div>
            @endif

            <div class="mb-8 grid gap-4 rounded-2xl bg-indigo-950 p-5 text-white shadow-xl shadow-indigo-950/10 sm:grid-cols-[auto_1fr] sm:items-center sm:p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-lime-300 text-xl font-black text-indigo-950">&#128203;</div>
                <div>
                    <p class="font-semibold">Tinjau detail pesanan dan selesaikan pembayaran Anda.</p>
                    <p class="mt-1 text-sm text-indigo-200">Pastikan jadwal dan total tagihan sudah sesuai sebelum mengunggah bukti pembayaran.</p>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">
                <div class="space-y-6">
                    <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:px-8">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">01</span>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white">Informasi lapangan</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Lapangan dan jadwal yang Anda pesan.</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 sm:p-8">
                            <div class="flex flex-col gap-5 sm:flex-row">
                                <div class="h-40 w-full shrink-0 overflow-hidden rounded-xl bg-gradient-to-br from-indigo-800 to-violet-700 sm:w-48">
                                    @if($primaryPhoto)
                                        <img src="{{ Storage::url($primaryPhoto->photo_path) }}" alt="{{ $field->field_name }}" class="h-full w-full object-cover">
                                    @else
                                        <span class="flex h-full items-center justify-center text-5xl">&#9917;</span>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-xl font-bold text-gray-900 dark:text-white">{{ $field->field_name }}</h4>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $field->sport_category }} &middot; {{ $field->location }}</p>
                                    @if($field->description)
                                        <p class="mt-3 text-sm leading-6 text-gray-600 dark:text-gray-300">{{ $field->description }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">Tanggal main</p>
                                    <p class="mt-1.5 text-sm font-bold text-gray-900 dark:text-white">{{ $dateLabel }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">Jam slot</p>
                                    <p class="mt-1.5 text-sm font-bold text-gray-900 dark:text-white">{{ substr($booking->schedule->start_time, 0, 5) }} &ndash; {{ substr($booking->schedule->end_time, 0, 5) }}</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:px-8">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">02</span>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white">Pembayaran</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Status dan detail tagihan pesanan.</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 sm:p-8">
                            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                                <div class="flex items-center justify-between py-3">
                                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">Total tagihan</p>
                                    <p class="text-sm font-bold text-indigo-700 dark:text-indigo-300">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                </div>
                                <div class="flex items-center justify-between py-3">
                                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">Metode pembayaran</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $booking->payment ? ($paymentMethodLabels[$booking->payment->payment_method] ?? $booking->payment->payment_method) : 'Belum dipilih' }}</p>
                                </div>
                                <div class="flex items-center justify-between py-3">
                                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">Status pembayaran</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $booking->payment ? ($paymentStatusLabels[$booking->payment->status] ?? ucfirst($booking->payment->status)) : 'Belum ada pembayaran' }}</p>
                                </div>
                            </div>

                            @if($booking->payment && $booking->payment->payment_proof)
                                <div class="mt-5 rounded-xl border border-gray-200 p-4 dark:border-gray-700">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Bukti pembayaran</p>
                                    <a href="{{ Storage::url($booking->payment->payment_proof) }}" target="_blank" class="mt-2 inline-flex items-center gap-1.5 rounded-lg border border-indigo-200 px-3 py-2 text-sm font-semibold text-indigo-700 transition hover:bg-indigo-50 dark:border-indigo-900 dark:text-indigo-300 dark:hover:bg-indigo-950/40">
                                        <span aria-hidden="true">&#128247;</span> Lihat bukti bayar
                                    </a>
                                </div>
                            @endif

                            @if($canPay)
                                <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
                                    <a href="{{ route('bookings.index') }}" class="inline-flex justify-center rounded-lg px-5 py-3 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white">Nanti saja</a>
                                    <a href="{{ route('payments.create', $booking) }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-indigo-500">
                                        <span aria-hidden="true">&rarr;</span> Lanjutkan pembayaran
                                    </a>
                                </div>
                            @elseif($waitingConfirm)
                                <div class="mt-6 flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800 dark:border-amber-900/60 dark:bg-amber-950/30 dark:text-amber-200">
                                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-amber-500 text-xs font-bold text-white">&#9203;</span>
                                    <p class="pt-0.5 font-medium">Bukti pembayaran sudah dikirim dan sedang menunggu konfirmasi pemilik lapangan.</p>
                                </div>
                            @elseif($isPaid)
                                <div class="mt-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 dark:border-emerald-900/60 dark:bg-emerald-950/30 dark:text-emerald-200">
                                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-xs font-bold text-white">&#10003;</span>
                                    <p class="pt-0.5 font-medium">Pembayaran lunas. Pesanan siap dimainkan, selamat berolahraga!</p>
                                </div>
                            @endif

                            @if($canCancel)
                                <div class="mt-6 border-t border-gray-100 pt-5 dark:border-gray-700">
                                    <form method="POST" action="{{ route('bookings.cancel', $booking) }}" onsubmit="return confirm('Batalkan pesanan ini? Tindakan tidak dapat dibatalkan.')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 px-4 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-50 dark:border-red-900/60 dark:hover:bg-red-950/30">
                                            <span aria-hidden="true">&#10005;</span> Batalkan pesanan
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </section>
                </div>

                <aside class="lg:sticky lg:top-6 lg:self-start">
                    <div class="overflow-hidden rounded-2xl bg-indigo-950 text-white shadow-xl shadow-indigo-950/10">
                        <div class="border-b border-white/10 px-6 py-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-lime-300">Ringkasan pesanan</p>
                            <p class="mt-1 text-sm text-indigo-200">Status terkini pesanan Anda.</p>
                        </div>
                        <div class="p-6">
                            <div class="flex h-36 items-center justify-center overflow-hidden rounded-xl bg-gradient-to-br from-indigo-800 to-violet-700">
                                @if($primaryPhoto)
                                    <img src="{{ Storage::url($primaryPhoto->photo_path) }}" alt="{{ $field->field_name }}" class="h-full w-full object-cover">
                                @else
                                    <span class="text-4xl">&#9917;</span>
                                @endif
                            </div>
                            <div class="mt-5">
                                <p class="text-xl font-bold">{{ $field->field_name }}</p>
                                <p class="mt-1 text-sm text-indigo-200">{{ $field->sport_category }} &middot; {{ $field->location }}</p>
                                <div class="mt-5 flex items-end justify-between border-t border-white/10 pt-4">
                                    <div>
                                        <p class="text-xs text-indigo-300">Total tagihan</p>
                                        <p class="mt-1 font-bold text-lime-300">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                    </div>
                                    <span class="rounded-full px-3 py-1.5 text-xs font-bold {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900 dark:border-amber-900/50 dark:bg-amber-950/30 dark:text-amber-100">
                        <p class="font-bold">Tips pembayaran</p>
                        <p class="mt-1 text-xs leading-5">Unggah bukti pembayaran sesuai nominal tagihan. Pemilik lapangan akan mengonfirmasi setelah bukti diverifikasi.</p>
                    </div>
                    <a href="{{ route('bookings.index') }}" class="mt-4 flex items-center justify-between rounded-xl border border-indigo-100 bg-white px-4 py-3 text-sm font-semibold text-indigo-700 shadow-sm transition hover:bg-indigo-50 dark:border-gray-700 dark:bg-gray-800 dark:text-indigo-300 dark:hover:bg-gray-700">
                        Semua pesanan saya <span aria-hidden="true">&rarr;</span>
                    </a>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
