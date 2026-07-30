<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Detail Pesanan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-4 rounded bg-green-100 px-4 py-3 text-green-700">{{ session('status') }}</div>
            @endif
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 space-y-4">
                <div class="flex justify-between gap-4">
                    <div>
                        <h3 class="font-bold text-lg text-gray-900 dark:text-white">{{ $booking->schedule->field->field_name }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $booking->schedule->field->location }}</p>
                    </div>
                    <span class="rounded px-3 py-1 h-fit text-sm font-semibold {{ $booking->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">{{ ucfirst($booking->status) }}</span>
                </div>
                <dl class="border-y border-gray-200 dark:border-gray-700 py-4 space-y-2 text-sm">
                    <div class="flex justify-between"><dt>Jadwal</dt><dd class="font-medium">{{ $booking->booking_date->translatedFormat('l, d F Y') }} · {{ $booking->schedule->start_time }}–{{ $booking->schedule->end_time }}</dd></div>
                    <div class="flex justify-between"><dt>Total</dt><dd class="font-bold">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</dd></div>
                    <div class="flex justify-between"><dt>Pembayaran</dt><dd>{{ $booking->payment ? ucfirst(str_replace('_', ' ', $booking->payment->status)) : 'Belum diunggah' }}</dd></div>
                </dl>
                @if(!$booking->payment && $booking->status === 'pending')
                    <a href="{{ route('payments.create', $booking) }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Lanjutkan Pembayaran</a>
                @elseif($booking->payment && $booking->payment->status === 'pending')
                    <p class="text-sm text-yellow-700 dark:text-yellow-400">Bukti pembayaran sudah dikirim dan sedang menunggu konfirmasi pemilik.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
