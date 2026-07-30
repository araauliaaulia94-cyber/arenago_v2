<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $field->field_name }}
            </h2>
            <a href="{{ route('fields.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">&larr; Kembali ke Katalog</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
            
            {{-- Bagian Kiri: Info Lapangan & Foto --}}
            <div class="md:w-2/3 space-y-6">
                {{-- Foto Galeri --}}
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    @if($field->photos->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($field->photos as $photo)
                                <img src="{{ Storage::url($photo->photo_path) }}" class="w-full h-48 object-cover rounded-lg" alt="Foto Lapangan">
                            @endforeach
                        </div>
                    @else
                        <div class="h-48 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-500">
                            Belum ada foto galeri
                        </div>
                    @endif
                </div>

                {{-- Deskripsi Lapangan --}}
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Informasi Lapangan</h3>
                    <div class="mb-4">
                        <span class="inline-block bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded font-semibold mr-2">{{ $field->sport_category }}</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">📍 {{ $field->location }}</span>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $field->description ?: 'Tidak ada deskripsi.' }}</p>
                    
                    <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="font-semibold text-gray-900 dark:text-white">Pemilik</h4>
                        <div class="flex items-center mt-2">
                            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center font-bold text-gray-600 mr-3">
                                {{ substr($field->owner->nama_usaha, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $field->owner->nama_usaha }}</p>
                                <p class="text-xs text-gray-500">{{ $field->owner->kota }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Ulasan --}}
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Ulasan & Penilaian (★ {{ number_format($avgRating, 1) ?: 'N/A' }})</h3>
                    @if($field->reviews->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400">Belum ada ulasan untuk lapangan ini.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($field->reviews as $review)
                                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="font-semibold text-sm text-gray-800 dark:text-gray-200">{{ $review->user->name }}</span>
                                        <span class="text-xs text-yellow-500 font-bold">★ {{ $review->rating }}</span>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $review->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Bagian Kanan: Jadwal & Booking --}}
            <div class="md:w-1/3">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 sticky top-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Pesan Slot</h3>
                    <p class="text-indigo-600 dark:text-indigo-400 font-semibold text-2xl mb-6">Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}<span class="text-sm text-gray-500 font-normal"> / jam</span></p>

                    <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-3">Jadwal Tersedia</h4>
                    @if($field->schedules->isEmpty())
                        <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada slot jadwal yang dibuka oleh pemilik.</p>
                    @else
                        <div class="space-y-3">
                            @foreach($field->schedules->groupBy('day') as $day => $schedules)
                                <div>
                                    <h5 class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $day }}</h5>
                                    <div class="flex flex-wrap gap-2 mt-1">
                                        @foreach($schedules as $schedule)
                                            <a href="{{ route('bookings.create', $schedule) }}" class="inline-block border border-indigo-300 dark:border-indigo-700 hover:bg-indigo-50 dark:hover:bg-indigo-900 text-indigo-700 dark:text-indigo-300 text-xs px-3 py-2 rounded transition">
                                                {{ $schedule->start_time }} - {{ $schedule->end_time }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-400 mt-4">* Klik pada jam untuk melanjutkan proses booking.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
