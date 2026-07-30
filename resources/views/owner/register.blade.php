<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Jadi Pemilik Lapangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('owner.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Nama Usaha -->
                        <div>
                            <x-input-label for="nama_usaha" :value="__('Nama Usaha / Lapangan')" />
                            <x-text-input id="nama_usaha" class="block mt-1 w-full" type="text" name="nama_usaha" :value="old('nama_usaha')" required autofocus autocomplete="nama_usaha" />
                            <x-input-error :messages="$errors->get('nama_usaha')" class="mt-2" />
                        </div>

                        <!-- Kota -->
                        <div class="mt-4">
                            <x-input-label for="kota" :value="__('Kota / Kabupaten')" />
                            <x-text-input id="kota" class="block mt-1 w-full" type="text" name="kota" :value="old('kota')" required autocomplete="kota" />
                            <x-input-error :messages="$errors->get('kota')" class="mt-2" />
                        </div>

                        <!-- Foto Usaha -->
                        <div class="mt-4">
                            <x-input-label for="foto_usaha" :value="__('Foto Usaha (Opsional)')" />
                            <input id="foto_usaha" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file" name="foto_usaha" accept="image/*">
                            <x-input-error :messages="$errors->get('foto_usaha')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Daftar Sekarang') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
