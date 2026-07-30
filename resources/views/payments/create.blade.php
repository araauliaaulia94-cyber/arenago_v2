<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Pembayaran Booking</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="font-bold text-lg text-gray-900 dark:text-white">{{ $booking->schedule->field->field_name }}</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Total yang harus dibayar: <span class="font-semibold">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span></p>
                <p class="mt-4 rounded bg-blue-50 p-3 text-sm text-blue-800">Pilih metode pembayaran, lakukan transfer sesuai nominal, lalu unggah foto/screenshot bukti pembayaran. Pemilik akan memverifikasinya.</p>
                <form method="POST" action="{{ route('payments.store', $booking) }}" enctype="multipart/form-data" class="mt-6 space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="payment_method" :value="__('Metode Pembayaran')" />
                        <select id="payment_method" name="payment_method" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" required>
                            <option value="bank_transfer" @selected(old('payment_method') === 'bank_transfer')>Transfer Bank</option>
                            <option value="qris" @selected(old('payment_method') === 'qris')>QRIS</option>
                            <option value="e_wallet" @selected(old('payment_method') === 'e_wallet')>E-Wallet</option>
                        </select>
                        <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="payment_proof" :value="__('Bukti Pembayaran (JPG/PNG, maks. 2 MB)')" />
                        <input id="payment_proof" name="payment_proof" type="file" accept="image/*" class="mt-1 block w-full text-sm" required>
                        <x-input-error :messages="$errors->get('payment_proof')" class="mt-2" />
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('bookings.show', $booking) }}" class="py-2 text-sm text-gray-600">Kembali</a>
                        <x-primary-button>Unggah Bukti Pembayaran</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
