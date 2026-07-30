<x-app-layout>
    @php
        $needsPayment = $bookings->filter(fn ($booking) => $booking->status === 'pending' && !$booking->payment)->count();
        $awaitingConfirmation = $bookings->filter(fn ($booking) => $booking->status === 'pending' && $booking->payment)->count();
        $paidBookings = $bookings->where('status', 'paid')->count();
    @endphp

    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-400">Booking saya</p>
            <h2 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Pesanan saya</h2>
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

            <section class="mb-8 overflow-hidden rounded-2xl bg-indigo-950 text-white shadow-xl shadow-indigo-950/10">
                <div class="grid gap-6 px-6 py-8 sm:px-8 lg:grid-cols-[1fr_auto] lg:items-end lg:px-10 lg:py-10">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-lime-300">Riwayat aktivitas</p>
                        <h3 class="mt-3 text-3xl font-bold tracking-tight">Semua jadwal bermain Anda.</h3>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-indigo-200">Pantau status booking, lanjutkan pembayaran, dan lihat detail reservasi dalam satu tempat.</p>
                    </div>
                    <a href="{{ route('fields.index') }}" class="inline-flex items-center justify-center rounded-lg bg-lime-300 px-4 py-3 text-sm font-bold text-indigo-950 transition hover:bg-lime-200">Cari lapangan</a>
                </div>
            </section>

            <section class="mb-8 grid gap-4 sm:grid-cols-3" aria-label="Ringkasan pesanan">
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total pesanan</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $bookings->count() }}</p>
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 text-lg text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">▤</span>
                    </div>
                </div>
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Perlu pembayaran</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold tracking-tight text-amber-600 dark:text-amber-400">{{ $needsPayment }}</p>
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-lg text-amber-700 dark:bg-amber-900 dark:text-amber-200">!</span>
                    </div>
                </div>
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Booking lunas</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold tracking-tight text-emerald-600 dark:text-emerald-400">{{ $paidBookings }}</p>
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-lg text-emerald-700 dark:bg-emerald-900 dark:text-emerald-200">✓</span>
                    </div>
                </div>
            </section>

            <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                <div class="flex flex-col gap-3 border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:flex-row sm:items-center sm:justify-between sm:px-8">
                    <div class="flex items-center gap-3">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">01</span>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white">Daftar pesanan</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Booking terbaru ditampilkan lebih dahulu.</p>
                        </div>
                    </div>
                    @if($awaitingConfirmation > 0)
                        <span class="w-fit rounded-full bg-violet-50 px-3 py-1 text-xs font-bold text-violet-700 dark:bg-violet-950/50 dark:text-violet-300">{{ $awaitingConfirmation }} menunggu konfirmasi</span>
                    @endif
                </div>

                <div class="p-6 sm:p-8">
                    @if($bookings->isEmpty())
                        <div class="rounded-2xl border border-dashed border-indigo-200 bg-indigo-50/60 px-6 py-12 text-center dark:border-indigo-900 dark:bg-indigo-950/20">
                            <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-2xl text-indigo-600 shadow-sm dark:bg-gray-800">⚽</span>
                            <h4 class="mt-4 text-lg font-bold text-gray-900 dark:text-white">Belum ada pesanan</h4>
                            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500 dark:text-gray-400">Temukan lapangan favorit Anda, pilih jadwal bermain, lalu buat booking pertama.</p>
                            <a href="{{ route('fields.index') }}" class="mt-6 inline-flex items-center rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-500">Cari lapangan</a>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($bookings as $booking)
                                @php
                                    $isAwaitingConfirmation = $booking->status === 'pending' && $booking->payment;
                                    $status = match ($booking->status) {
                                        'paid' => ['Lunas', 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/50 dark:text-emerald-300'],
                                        'completed' => ['Selesai', 'bg-indigo-100 text-indigo-800 dark:bg-indigo-950/50 dark:text-indigo-300'],
                                        'cancelled' => ['Dibatalkan', 'bg-red-100 text-red-800 dark:bg-red-950/50 dark:text-red-300'],
                                        default => $isAwaitingConfirmation
                                            ? ['Menunggu konfirmasi', 'bg-violet-100 text-violet-800 dark:bg-violet-950/50 dark:text-violet-300']
                                            : ['Menunggu pembayaran', 'bg-amber-100 text-amber-800 dark:bg-amber-950/50 dark:text-amber-300'],
                                    };
                                @endphp
                                <article class="overflow-hidden rounded-2xl border border-gray-200 bg-gray-50 transition hover:border-indigo-200 hover:bg-indigo-50/40 dark:border-gray-700 dark:bg-gray-900/50 dark:hover:border-indigo-800 dark:hover:bg-indigo-950/20">
                                    <div class="flex flex-col gap-5 p-4 sm:flex-row sm:p-5">
                                        <div class="h-32 overflow-hidden rounded-xl bg-gradient-to-br from-indigo-800 to-violet-700 sm:h-28 sm:w-40 sm:shrink-0">
                                            @if($booking->schedule->field->photos->isNotEmpty())
                                                <img src="{{ Storage::url($booking->schedule->field->photos->first()->photo_path) }}" alt="{{ $booking->schedule->field->field_name }}" class="h-full w-full object-cover">
                                            @else
                                                <span class="flex h-full items-center justify-center text-3xl">⚽</span>
                                            @endif
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                                <div class="min-w-0">
                                                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-indigo-600 dark:text-indigo-300">{{ $booking->schedule->field->sport_category }}</p>
                                                    <h4 class="mt-1 truncate text-lg font-bold text-gray-900 dark:text-white">{{ $booking->schedule->field->field_name }}</h4>
                                                    <p class="mt-1 truncate text-sm text-gray-500 dark:text-gray-400">{{ $booking->schedule->field->location }}</p>
                                                </div>
                                                <span class="w-fit rounded-full px-3 py-1.5 text-xs font-bold {{ $status[1] }}">{{ $status[0] }}</span>
                                            </div>
                                            <div class="mt-4 grid gap-3 border-t border-gray-200 pt-4 text-sm dark:border-gray-700 sm:grid-cols-3">
                                                <div><p class="text-xs text-gray-500 dark:text-gray-400">Tanggal bermain</p><p class="mt-1 font-bold text-gray-900 dark:text-white">{{ $booking->booking_date?->translatedFormat('d M Y') ?? '-' }}</p></div>
                                                <div><p class="text-xs text-gray-500 dark:text-gray-400">Jam</p><p class="mt-1 font-bold text-gray-900 dark:text-white">{{ substr($booking->schedule->start_time, 0, 5) }} – {{ substr($booking->schedule->end_time, 0, 5) }}</p></div>
                                                <div><p class="text-xs text-gray-500 dark:text-gray-400">Total</p><p class="mt-1 font-bold text-indigo-700 dark:text-indigo-300">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p></div>
                                            </div>
                                            <div class="mt-5 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                                                <a href="{{ route('bookings.show', $booking) }}" class="inline-flex justify-center rounded-lg border border-indigo-200 px-4 py-2.5 text-sm font-semibold text-indigo-700 transition hover:bg-indigo-50 dark:border-indigo-900 dark:text-indigo-300 dark:hover:bg-indigo-950/40">Lihat detail</a>
                                                @if($booking->status === 'pending' && !$booking->payment)
                                                    <a href="{{ route('payments.create', $booking) }}" class="inline-flex justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500">Lanjutkan pembayaran</a>
                                                @endif
                                            </div>
                                        </div>
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
