<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Pesanan Masuk') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($bookings->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400 text-center">Belum ada pesanan masuk.</p>
                @else
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-4 py-3">Penyewa</th>
                                <th class="px-4 py-3">Lapangan</th>
                                <th class="px-4 py-3">Hari / Jam</th>
                                <th class="px-4 py-3">Total</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Bukti Bayar</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                                <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $booking->user->name }}</td>
                                    <td class="px-4 py-3">{{ $booking->schedule->field->field_name }}</td>
                                    <td class="px-4 py-3">{{ $booking->schedule->day }} · {{ $booking->schedule->start_time }} - {{ $booking->schedule->end_time }}</td>
                                    <td class="px-4 py-3">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 text-xs rounded
                                            {{ $booking->status === 'paid' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                        ">{{ ucfirst($booking->status) }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($booking->payment && $booking->payment->payment_proof)
                                            <a href="{{ Storage::url($booking->payment->payment_proof) }}" target="_blank" class="text-indigo-600 hover:underline">Lihat</a>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($booking->status === 'pending' && $booking->payment)
                                            <form method="POST" action="{{ route('owner.bookings.confirm', $booking) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-green-600 hover:underline font-semibold">Konfirmasi</button>
                                            </form>
                                        @elseif($booking->status === 'paid')
                                            <span class="text-green-600 font-semibold">✓ Lunas</span>
                                        @else
                                            <span class="text-gray-400">Menunggu</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
