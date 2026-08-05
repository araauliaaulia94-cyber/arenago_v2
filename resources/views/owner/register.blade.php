<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-400">Owner workspace</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Daftar sebagai pemilik lapangan</h2>
            </div>
            <a href="{{ route('dashboard') }}" class="hidden items-center gap-2 text-sm font-semibold text-gray-600 transition hover:text-indigo-600 dark:text-gray-300 sm:inline-flex">
                <span aria-hidden="true">&larr;</span> Kembali ke dashboard
            </a>
        </div>
    </x-slot>

    <div class="bg-gradient-to-b from-indigo-50 via-gray-50 to-gray-100 py-8 dark:from-gray-900 dark:via-gray-900 dark:to-gray-950 sm:py-12">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8" x-data="{
            namaUsaha: @js(old('nama_usaha')),
            kota: @js(old('kota')),
            alamat: @js(old('alamat_lengkap')),
            rekening: @js(old('rekening_bank')),
            fileName: ''
        }">
            <div class="mb-8 grid gap-4 rounded-2xl bg-indigo-950 p-5 text-white shadow-xl shadow-indigo-950/10 sm:grid-cols-[auto_1fr] sm:items-center sm:p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-lime-300 text-xl font-black text-indigo-950">&#127970;</div>
                <div>
                    <p class="font-semibold">Lengkapi data usaha Anda untuk mulai menerima pesanan.</p>
                    <p class="mt-1 text-sm text-indigo-200">Setelah disetujui, Anda dapat menambahkan lapangan dan mengatur slot jadwal.</p>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">
                <form method="POST" action="{{ route('owner.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:px-8">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">01</span>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white">Identitas usaha</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Informasi yang menjadi rujukan penyewa.</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid gap-5 p-6 sm:grid-cols-2 sm:p-8">
                            <div class="sm:col-span-2">
                                <x-input-label for="nama_usaha" :value="__('Nama usaha / lapangan')" class="font-semibold" />
                                <x-text-input id="nama_usaha" class="mt-2 block w-full" type="text" name="nama_usaha" x-model="namaUsaha" placeholder="Contoh: Arena Futsal Senayan" required autofocus />
                                <x-input-error :messages="$errors->get('nama_usaha')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="kota" :value="__('Kota / kabupaten')" class="font-semibold" />
                                <x-text-input id="kota" class="mt-2 block w-full" type="text" name="kota" x-model="kota" placeholder="Contoh: Jakarta Selatan" required />
                                <x-input-error :messages="$errors->get('kota')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="rekening_bank" :value="__('Rekening bank (opsional)')" class="font-semibold" />
                                <x-text-input id="rekening_bank" class="mt-2 block w-full" type="text" name="rekening_bank" x-model="rekening" placeholder="Contoh: BCA 1234567890 a.n. Budi" />
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Akan ditampilkan kepada penyewa sebagai instruksi transfer.</p>
                                <x-input-error :messages="$errors->get('rekening_bank')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-2">
                                <x-input-label for="alamat_lengkap" :value="__('Alamat lengkap usaha')" class="font-semibold" />
                                <textarea id="alamat_lengkap" name="alamat_lengkap" rows="3" class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200" placeholder="Jalan, nomor, RT/RW, kelurahan, kecamatan, kota." required>{{ old('alamat_lengkap') }}</textarea>
                                <x-input-error :messages="$errors->get('alamat_lengkap')" class="mt-2" />
                            </div>
                        </div>
                    </section>

                    <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:px-8">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">02</span>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white">Foto usaha</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Foto opsional untuk mempercayai katalog Anda.</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 sm:p-8">
                            <label for="foto_usaha" class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-indigo-200 bg-indigo-50/60 px-6 py-10 text-center transition hover:border-indigo-500 hover:bg-indigo-50 dark:border-indigo-900 dark:bg-indigo-950/30 dark:hover:bg-indigo-950/50">
                                <span class="flex h-11 w-11 items-center justify-center rounded-full bg-white text-xl text-indigo-600 shadow-sm dark:bg-gray-800">&#8533;</span>
                                <span class="mt-3 text-sm font-bold text-indigo-700 dark:text-indigo-300">Pilih foto usaha</span>
                                <span class="mt-1 text-xs text-gray-500 dark:text-gray-400">JPG atau PNG &middot; maksimal 2 MB &middot; opsional</span>
                            </label>
                            <input id="foto_usaha" type="file" name="foto_usaha" accept="image/*" class="sr-only" @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''">
                            <p x-show="fileName" x-cloak x-text="fileName" class="mt-3 truncate text-xs text-gray-500 dark:text-gray-400"></p>
                            <x-input-error :messages="$errors->get('foto_usaha')" class="mt-2" />
                        </div>
                    </section>

                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <a href="{{ route('dashboard') }}" class="inline-flex justify-center rounded-lg px-5 py-3 text-sm font-semibold text-gray-600 transition hover:bg-white hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white">Batalkan</a>
                        <button type="submit" class="inline-flex justify-center rounded-lg bg-indigo-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-indigo-500">Daftar sebagai pemilik</button>
                    </div>
                </form>

                <aside class="lg:sticky lg:top-6 lg:self-start">
                    <section class="overflow-hidden rounded-2xl bg-indigo-950 text-white shadow-xl shadow-indigo-950/10">
                        <div class="border-b border-white/10 px-6 py-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-lime-300">Manfaat pemilik</p>
                            <p class="mt-1 text-sm text-indigo-200">Yang akan Anda dapatkan setelah terdaftar.</p>
                        </div>
                        <ul class="space-y-4 p-6 text-sm">
                            <li class="flex gap-3">
                                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-lime-300 text-xs font-bold text-indigo-950">&#10003;</span>
                                <span class="text-indigo-100">Publikasikan lapangan agar muncul di katalog penyewa.</span>
                            </li>
                            <li class="flex gap-3">
                                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-lime-300 text-xs font-bold text-indigo-950">&#10003;</span>
                                <span class="text-indigo-100">Atur slot jadwal operasional per hari sesuai ketersediaan venue.</span>
                            </li>
                            <li class="flex gap-3">
                                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-lime-300 text-xs font-bold text-indigo-950">&#10003;</span>
                                <span class="text-indigo-100">Terima pesanan masuk dan konfirmasi pembayaran secara atomik.</span>
                            </li>
                        </ul>
                    </section>
                    <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900 dark:border-amber-900/50 dark:bg-amber-950/30 dark:text-amber-100">
                        <p class="font-bold">Catatan</p>
                        <p class="mt-1 text-xs leading-5">Pada mode development, pendaftaran langsung disetujui. Pada produksi, verifikasi admin akan diaktifkan.</p>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
