<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Konfirmasi Booking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Ringkasan Pesanan</h3>
                
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 mb-6">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600 dark:text-gray-400">Lapangan</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $schedule->field->field_name }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600 dark:text-gray-400">Kategori</span>
                        <span class="text-gray-900 dark:text-white">{{ $schedule->field->sport_category }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600 dark:text-gray-400">Lokasi</span>
                        <span class="text-gray-900 dark:text-white">{{ $schedule->field->location }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600 dark:text-gray-400">Jadwal</span>
                        <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $schedule->day }}, {{ $schedule->start_time }} - {{ $schedule->end_time }}</span>
                    </div>
                    <hr class="my-4 border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between text-lg font-bold">
                        <span class="text-gray-900 dark:text-white">Total Bayar</span>
                        <span class="text-indigo-600 dark:text-indigo-400">Rp {{ number_format($schedule->field->price_per_hour, 0, ',', '.') }}</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('bookings.store') }}">
                    @csrf
                    <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                    <div class="mb-4">
                        <x-input-label for="booking_date" :value="__('Tanggal Booking')" />
                        <x-text-input id="booking_date" name="booking_date" type="date" class="mt-1 block w-full" :value="old('booking_date')" :min="now()->toDateString()" required />
                        <p class="mt-1 text-xs text-gray-500">Pilih tanggal yang jatuh pada hari {{ $schedule->day }}.</p>
                        <x-input-error :messages="$errors->get('booking_date')" class="mt-2" />
                    </div>
                    
                    <div class="flex items-center justify-end">
                        <a href="{{ route('fields.show', $schedule->field) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline mr-4">Batal</a>
                        <x-primary-button>{{ __('Buat Pesanan') }}</x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
