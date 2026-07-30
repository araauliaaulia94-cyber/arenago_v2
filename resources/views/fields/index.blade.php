<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cari Lapangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Filter & Search --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 mb-6">
                <form method="GET" action="{{ route('fields.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <x-input-label for="search" :value="__('Cari Nama')" />
                        <x-text-input id="search" name="search" type="text" class="mt-1 w-full" value="{{ request('search') }}" placeholder="Contoh: Arena Futsal" />
                    </div>
                    <div>
                        <x-input-label for="kota" :value="__('Kota / Lokasi')" />
                        <select id="kota" name="kota" class="mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Semua Kota</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ request('kota') == $city ? 'selected' : '' }}>{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="sport" :value="__('Olahraga')" />
                        <select id="sport" name="sport" class="mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Semua Olahraga</option>
                            @foreach($sports as $sport)
                                <option value="{{ $sport }}" {{ request('sport') == $sport ? 'selected' : '' }}>{{ $sport }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="max_price" :value="__('Harga Maksimum')" />
                        <x-text-input id="max_price" name="max_price" type="number" step="1000" class="mt-1 w-full" value="{{ request('max_price') }}" placeholder="Contoh: 150000" />
                    </div>
                    <div class="flex items-end">
                        <x-primary-button class="w-full justify-center">{{ __('Terapkan Filter') }}</x-primary-button>
                    </div>
                </form>
            </div>

            {{-- Fields Catalog --}}
            @if($fields->isEmpty())
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-center text-gray-500 dark:text-gray-400">
                    Tidak ada lapangan yang cocok dengan pencarian Anda.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($fields as $field)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden flex flex-col">
                            <div class="h-48 bg-gray-200 dark:bg-gray-700 relative">
                                @if($field->photos->count() > 0)
                                    <img src="{{ Storage::url($field->photos->first()->photo_path) }}" alt="{{ $field->field_name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center w-full h-full text-gray-400">Belum ada foto</div>
                                @endif
                                <div class="absolute top-2 right-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded">
                                    ★ {{ number_format($field->reviews->avg('rating'), 1) ?: 'N/A' }}
                                </div>
                            </div>
                            <div class="p-4 flex-1 flex flex-col">
                                <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-1">{{ $field->field_name }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">{{ $field->sport_category }} · {{ $field->location }}</p>
                                <p class="text-indigo-600 dark:text-indigo-400 font-semibold mb-4">Rp {{ number_format($field->price_per_hour, 0, ',', '.') }} / jam</p>
                                
                                <div class="mt-auto">
                                    <a href="{{ route('fields.show', $field) }}" class="block w-full text-center bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold py-2 px-4 rounded transition">
                                        Lihat Detail & Jadwal
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6">
                    {{ $fields->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
