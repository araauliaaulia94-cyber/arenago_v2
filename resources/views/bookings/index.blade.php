<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                @if($bookings->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400 text-center">Anda belum memiliki pesanan.</p>
                @else
                    <div class="space-y-4">
                        @foreach($bookings as $booking)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 flex flex-col md:flex-row justify-between items-center gap-4">
                                <div>
                                    <h4 class="font-bold text-lg text-gray-900 dark:text-white">{{ $booking->schedule->field->field_name }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $booking->booking_date->translatedFormat('d M Y') }}, {{ $booking->schedule->start_time }} - {{ $booking->schedule->end_time }}</p>
                                    <p class="text-indigo-600 dark:text-indigo-400 font-semibold mt-1">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                </div>
                                <div class="flex flex-col items-end gap-2">
                                    <span class="px-3 py-1 text-sm rounded-full font-semibold
                                        {{ $booking->status === 'paid' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                    ">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                    
                                    <a href="{{ route('bookings.show', $booking) }}" class="text-sm text-indigo-600 hover:underline">Lihat Detail</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
