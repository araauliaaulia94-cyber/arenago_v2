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

        $needsAction = $bookings->filter(fn ($b) => $b->status === 'pending' && $b->payment)->count();
        $paidCount = $bookings->where('status', 'paid')->count();
        $pendingPayment = $bookings->filter(fn ($b) => $b->status === 'pending' && !$b->payment)->count();

        // Surface the most actionable bookings first, keep latest order within each group.
        $sortedBookings = $bookings->sortBy(function ($b) {
            if ($b->status === 'pending' && $b->payment) return 0;
            if ($b->status === 'paid') return 1;
            if ($b->status === 'pending') return 2;
            return 3;
        })->values();

        $statusBadge = function ($booking) {
            if ($booking->status === 'completed') {
                return ['label' => 'Selesai', 'class' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-950/50 dark:text-indigo-300'];
            }
            if ($booking->status === 'paid') {
                return ['label' => 'Lunas', 'class' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/50 dark:text-emerald-300'];
            }
            if ($booking->status === 'cancelled') {
                return ['label' => 'Dibatalkan', 'class' => 'bg-red-100 text-red-800 dark:bg-red-950/50 dark:text-red-300'];
            }
            if ($booking->status === 'pending' && $booking->payment) {
                return ['label' => 'Menunggu konfirmasi', 'class' => 'bg-amber-100 text-amber-800 dark:bg-amber-950/50 dark:text-amber-300'];
            }
            return ['label' => 'Menunggu pembayaran', 'class' => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300'];
        };
    @endphp

    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-400">Owner workspace</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Pesanan masuk</h2>
            </div>
            <a href="{{ route('owner.dashboard') }}" class="hidden items-center gap-2 text-sm font-semibold text-gray-600 transition hover:text-indigo-600 dark:text-gray-300 sm:inline-flex">
                <span aria-hidden="true">&larr;</span> Kembali ke dashboard pemilik
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

            @if(session('error'))
                <div class="mb-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800 shadow-sm dark:border-red-900/60 dark:bg-red-950/30 dark:text-red-200">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-red-600 text-xs font-bold text-white">!</span>
                    <p class="pt-0.5 font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <div class="mb-8 flex flex-col gap-5 rounded-2xl bg-indigo-950 p-6 text-white shadow-xl shadow-indigo-950/10 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-lime-300">Ringkasan pesanan</p>
                    <h3 class="mt-2 text-2xl font-bold">Kelola setiap pesanan penyewa dengan cepat.</h3>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-indigo-200">Tinjau bukti pembayaran, konfirmasi pesanan yang sudah dibayar, dan pantau status setiap booking untuk lapangan Anda.</p>
                </div>
                @if($needsAction > 0)
                    <span class="inline-flex w-fit items-center gap-2 rounded-full bg-amber-300 px-4 py-2 text-sm font-bold text-amber-950">{{ $needsAction }} perlu konfirmasi</span>
                @endif
            </div>

            <section class="mb-8 grid gap-4 sm:grid-cols-3" aria-label="Ringkasan pesanan">
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total pesanan</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $bookings->count() }}</p>
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 text-lg text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">&#9993;</span>
                    </div>
                </div>
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Perlu konfirmasi</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold tracking-tight text-amber-600 dark:text-amber-400">{{ $needsAction }}</p>
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-lg text-amber-700 dark:bg-amber-900 dark:text-amber-200">&#9203;</span>
                    </div>
                </div>
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pesanan lunas</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold tracking-tight text-emerald-600 dark:text-emerald-400">{{ $paidCount }}</p>
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-lg text-emerald-700 dark:bg-emerald-900 dark:text-emerald-200">&#10003;</span>
                    </div>
                </div>
            </section>

            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">
                <div class="space-y-6">
                    <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="flex flex-col gap-3 border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:flex-row sm:items-center sm:justify-between sm:px-8">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">01</span>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white">Daftar pesanan penyewa</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Pesanan yang perlu tindakan ditampilkan paling atas.</p>
                                </div>
                            </div>
                            <span class="w-fit rounded-full bg-indigo-50 px-3 py-1 text-xs font-bold text-indigo-700 dark:bg-indigo-950/50 dark:text-indigo-300">{{ $bookings->count() }} pesanan</span>
                        </div>

                        <div class="p-6 sm:p-8">
                            @if($bookings->isEmpty())
                                <div class="rounded-2xl border border-dashed border-indigo-200 bg-indigo-50/60 px-6 py-12 text-center dark:border-indigo-900 dark:bg-indigo-950/20">
                                    <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-2xl text-indigo-600 shadow-sm dark:bg-gray-800">&#128230;</span>
                                    <h4 class="mt-4 text-lg font-bold text-gray-900 dark:text-white">Belum ada pesanan masuk</h4>
                                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500 dark:text-gray-400">Pastikan lapangan Anda telah dipublikasikan dan slot jadwal dibuka agar penyewa dapat melakukan booking.</p>
                                    <a href="{{ route('owner.fields.index') }}" class="mt-6 inline-flex items-center rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-500">Kelola lapangan saya</a>
                                </div>
                            @else
                                <div class="space-y-4">
                                    @foreach($sortedBookings as $booking)
                                        @php
                                            $badge = $statusBadge($booking);
                                            $isActionable = $booking->status === 'pending' && $booking->payment;
                                            $scheduleDay = $dayLabels[$booking->schedule->day] ?? $booking->schedule->day;
                                            $dateLabel = $scheduleDay . ', ' . $booking->booking_date->format('j') . ' ' . ($monthLabels[$booking->booking_date->month] ?? '') . ' ' . $booking->booking_date->year;
                                            $methodLabel = $booking->payment ? ($paymentMethodLabels[$booking->payment->payment_method] ?? $booking->payment->payment_method) : null;
                                        @endphp
                                        <article class="rounded-2xl border border-gray-200 bg-white p-5 transition hover:shadow-md hover:shadow-indigo-950/5 dark:border-gray-700 dark:bg-gray-900 {{ $isActionable ? 'ring-2 ring-amber-300 dark:ring-amber-500/60' : '' }}">
                                            <div class="flex flex-wrap items-start justify-between gap-3">
                                                <div class="min-w-0">
                                                    <div class="flex items-center gap-2">
                                                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">{{ strtoupper(substr($booking->user->name, 0, 1)) }}</span>
                                                        <div class="min-w-0">
                                                            <p class="truncate font-bold text-gray-900 dark:text-white">{{ $booking->user->name }}</p>
                                                            <p class="truncate text-xs text-gray-500 dark:text-gray-400">{{ $booking->schedule->field->field_name }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="rounded-full px-3 py-1.5 text-xs font-bold {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                                            </div>

                                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                                <div>
                                                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">Tanggal main</p>
                                                    <p class="mt-1.5 text-sm font-bold text-gray-900 dark:text-white">{{ $dateLabel }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">Jam slot</p>
                                                    <p class="mt-1.5 text-sm font-bold text-gray-900 dark:text-white">{{ substr($booking->schedule->start_time, 0, 5) }} &ndash; {{ substr($booking->schedule->end_time, 0, 5) }}</p>
                                                </div>
                                            </div>

                                            <div class="mt-4 flex flex-wrap items-end justify-between gap-3 border-t border-gray-100 pt-4 dark:border-gray-800">
                                                <div>
                                                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">Total bayar</p>
                                                    <p class="mt-1.5 font-bold text-indigo-700 dark:text-indigo-300">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                                    @if($methodLabel)
                                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">via {{ $methodLabel }}</p>
                                                    @endif
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    @if($booking->payment && $booking->payment->payment_proof)
                                                        <a href="{{ Storage::url($booking->payment->payment_proof) }}" target="_blank" class="inline-flex items-center gap-1.5 rounded-lg border border-indigo-200 px-3 py-2 text-sm font-semibold text-indigo-700 transition hover:bg-indigo-50 dark:border-indigo-900 dark:text-indigo-300 dark:hover:bg-indigo-950/40">
                                                            <span aria-hidden="true">&#128247;</span> Lihat bukti bayar
                                                        </a>
                                                    @else
                                                        <span class="text-xs text-gray-400 dark:text-gray-500">Belum ada bukti bayar</span>
                                                    @endif
                                                </div>
                                            </div>

                                            @if($isActionable)
                                                <form method="POST" action="{{ route('owner.bookings.confirm', $booking) }}" class="mt-4" onsubmit="return confirm('Konfirmasi pembayaran dari {{ $booking->user->name }} sebesar Rp {{ number_format($booking->total_price, 0, ',', '.') }}? Pesanan akan ditandai lunas.')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-emerald-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-500 sm:w-auto">
                                                        <span aria-hidden="true">&#10003;</span> Konfirmasi pembayaran
                                                    </button>
                                                </form>
                                            @elseif($booking->status === 'paid')
                                                <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center">
                                                    <div class="flex flex-1 items-center gap-2 rounded-lg bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-300">
                                                        <span aria-hidden="true">&#10003;</span> Pembayaran lunas &mdash; siap dimainkan.
                                                    </div>
                                                    <form method="POST" action="{{ route('owner.bookings.complete', $booking) }}" onsubmit="return confirm('Tandai pesanan {{ $booking->user->name }} sebagai selesai?')">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg border border-indigo-200 px-4 py-3 text-sm font-semibold text-indigo-700 transition hover:bg-indigo-50 dark:border-indigo-900 dark:text-indigo-300 dark:hover:bg-indigo-950/40">
                                                            <span aria-hidden="true">&#10003;</span> Tandai selesai
                                                        </button>
                                                    </form>
                                                </div>
                                            @elseif($booking->status === 'completed')
                                                <div class="mt-4 flex items-center gap-2 rounded-lg bg-indigo-50 px-4 py-3 text-sm font-semibold text-indigo-700 dark:bg-indigo-950/30 dark:text-indigo-300">
                                                    <span aria-hidden="true">&#10003;</span> Pesanan selesai.
                                                </div>
                                            @elseif($booking->status === 'cancelled')
                                                <div class="mt-4 flex items-center gap-2 rounded-lg bg-gray-50 px-4 py-3 text-sm font-semibold text-gray-500 dark:bg-gray-800/60 dark:text-gray-400">
                                                    <span aria-hidden="true">&#10005;</span> Pesanan dibatalkan.
                                                </div>
                                            @elseif($booking->status === 'pending')
                                                <div class="mt-4 flex items-center gap-2 rounded-lg bg-gray-50 px-4 py-3 text-sm font-semibold text-gray-500 dark:bg-gray-800/60 dark:text-gray-400">
                                                    <span aria-hidden="true">&#9203;</span> Menunggu penyewa mengunggah bukti pembayaran.
                                                </div>
                                            @endif
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
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-lime-300">Status pesanan</p>
                            <p class="mt-1 text-sm text-indigo-200">Pantau tindakan yang perlu dilakukan.</p>
                        </div>
                        <div class="space-y-4 p-6">
                            <div class="flex items-center justify-between border-b border-white/10 pb-4">
                                <div>
                                    <p class="text-sm text-indigo-200">Perlu konfirmasi</p>
                                    <p class="mt-1 text-xs text-indigo-300">Bukti bayar sudah diunggah</p>
                                </div>
                                <p class="text-2xl font-bold {{ $needsAction > 0 ? 'text-amber-300' : 'text-white' }}">{{ $needsAction }}</p>
                            </div>
                            <div class="flex items-center justify-between border-b border-white/10 pb-4">
                                <div>
                                    <p class="text-sm text-indigo-200">Menunggu pembayaran</p>
                                    <p class="mt-1 text-xs text-indigo-300">Penyewa belum unggah bukti</p>
                                </div>
                                <p class="text-2xl font-bold text-white">{{ $pendingPayment }}</p>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-indigo-200">Lunas</p>
                                    <p class="mt-1 text-xs text-indigo-300">Pesanan dikonfirmasi</p>
                                </div>
                                <p class="text-2xl font-bold text-lime-300">{{ $paidCount }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900 dark:border-amber-900/50 dark:bg-amber-950/30 dark:text-amber-100">
                        <p class="font-bold">Cara mengonfirmasi pesanan</p>
                        <p class="mt-1 text-xs leading-5">Buka bukti pembayaran penyewa, pastikan nominal sesuai, lalu tekan tombol <span class="font-semibold">Konfirmasi pembayaran</span>. Status akan langsung berubah menjadi lunas dan penyewa mendapat notifikasi.</p>
                    </div>
                    <a href="{{ route('owner.fields.index') }}" class="mt-4 flex items-center justify-between rounded-xl border border-indigo-100 bg-white px-4 py-3 text-sm font-semibold text-indigo-700 shadow-sm transition hover:bg-indigo-50 dark:border-gray-700 dark:bg-gray-800 dark:text-indigo-300 dark:hover:bg-gray-700">
                        Kelola lapangan saya <span aria-hidden="true">&rarr;</span>
                    </a>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
