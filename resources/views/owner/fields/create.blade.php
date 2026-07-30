<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-400">Owner workspace</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Tambahkan lapangan baru</h2>
            </div>
            <a href="{{ route('owner.fields.index') }}" class="hidden items-center gap-2 text-sm font-semibold text-gray-600 transition hover:text-indigo-600 dark:text-gray-300 sm:inline-flex">
                <span aria-hidden="true">←</span> Kembali ke lapangan saya
            </a>
        </div>
    </x-slot>

    <div class="bg-gradient-to-b from-indigo-50 via-gray-50 to-gray-100 py-8 dark:from-gray-900 dark:via-gray-900 dark:to-gray-950 sm:py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8" x-data="{
            fieldName: @js(old('field_name')),
            category: @js(old('sport_category')),
            location: @js(old('location')),
            price: @js(old('price_per_hour')),
            status: @js(old('status', 'available')),
            files: [],
            money() {
                return this.price ? new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(this.price) : 'Belum ditentukan';
            }
        }">
            <div class="mb-8 grid gap-4 rounded-2xl bg-indigo-950 p-5 text-white shadow-xl shadow-indigo-950/10 sm:grid-cols-[auto_1fr] sm:items-center sm:p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-lime-300 text-xl font-black text-indigo-950">1</div>
                <div>
                    <p class="font-semibold">Mulai dari informasi yang paling dicari penyewa.</p>
                    <p class="mt-1 text-sm text-indigo-200">Lengkapi data, tampilkan galeri terbaik, lalu atur slot jadwal setelah lapangan dibuat.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('owner.fields.store') }}" enctype="multipart/form-data" class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">
                @csrf

                <div class="space-y-6">
                    <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:px-8">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">01</span>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white">Identitas lapangan</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Informasi utama yang tampil di katalog.</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid gap-5 p-6 sm:grid-cols-2 sm:p-8">
                            <div class="sm:col-span-2">
                                <x-input-label for="field_name" :value="__('Nama lapangan')" class="font-semibold" />
                                <x-text-input id="field_name" class="mt-2 block w-full" type="text" name="field_name" x-model="fieldName" placeholder="Contoh: Lapangan A Indoor" required autofocus />
                                <x-input-error :messages="$errors->get('field_name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="sport_category" :value="__('Cabang olahraga')" class="font-semibold" />
                                <select id="sport_category" name="sport_category" x-model="category" class="mt-2 block w-full rounded-lg border-gray-300 py-2.5 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200" required>
                                    <option value="">Pilih kategori</option>
                                    @foreach(['Futsal', 'Badminton', 'Basket', 'Mini Soccer', 'Voli', 'Tenis'] as $category)
                                        <option value="{{ $category }}">{{ $category }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('sport_category')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="location" :value="__('Kota / lokasi')" class="font-semibold" />
                                <x-text-input id="location" class="mt-2 block w-full" type="text" name="location" x-model="location" placeholder="Contoh: Jakarta Selatan" required />
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="price_per_hour" :value="__('Harga per jam')" class="font-semibold" />
                                <div class="mt-2 flex overflow-hidden rounded-lg border border-gray-300 shadow-sm focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500 dark:border-gray-700">
                                    <span class="inline-flex items-center border-r border-gray-300 bg-gray-50 px-3 text-sm font-semibold text-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400">Rp</span>
                                    <input id="price_per_hour" class="block min-w-0 flex-1 border-0 bg-transparent px-3 py-2.5 text-gray-900 focus:ring-0 dark:text-white" type="number" name="price_per_hour" x-model="price" min="0" step="1000" placeholder="150000" required>
                                </div>
                                <x-input-error :messages="$errors->get('price_per_hour')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="status" :value="__('Status publikasi')" class="font-semibold" />
                                <select id="status" name="status" x-model="status" class="mt-2 block w-full rounded-lg border-gray-300 py-2.5 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200" required>
                                    <option value="available">Tersedia untuk booking</option>
                                    <option value="unavailable">Simpan sebagai tidak tersedia</option>
                                </select>
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Lapangan tersedia langsung muncul di katalog penyewa.</p>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                        </div>
                    </section>

                    <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:px-8">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">02</span>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white">Cerita dan galeri venue</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Foto yang baik membantu penyewa memilih lebih yakin.</p>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-5 p-6 sm:p-8">
                            <div>
                                <x-input-label for="description" :value="__('Deskripsi singkat')" class="font-semibold" />
                                <textarea id="description" name="description" rows="4" class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200" placeholder="Ceritakan jenis lapangan, fasilitas, atau keunggulannya.">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="photos" :value="__('Foto lapangan')" class="font-semibold" />
                                <label for="photos" class="mt-2 flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-indigo-200 bg-indigo-50/60 px-6 py-10 text-center transition hover:border-indigo-500 hover:bg-indigo-50 dark:border-indigo-900 dark:bg-indigo-950/30 dark:hover:bg-indigo-950/50">
                                    <span class="flex h-11 w-11 items-center justify-center rounded-full bg-white text-xl text-indigo-600 shadow-sm dark:bg-gray-800">↑</span>
                                    <span class="mt-3 text-sm font-bold text-indigo-700 dark:text-indigo-300">Pilih foto dari perangkat</span>
                                    <span class="mt-1 text-xs text-gray-500 dark:text-gray-400">JPG atau PNG · maksimal 2 MB per foto · pilih beberapa sekaligus</span>
                                </label>
                                <input id="photos" type="file" name="photos[]" multiple accept="image/*" class="sr-only" @change="files = Array.from($event.target.files)">
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Di Windows, tahan <kbd class="rounded border border-gray-300 bg-white px-1 font-medium dark:border-gray-600 dark:bg-gray-800">Ctrl</kbd> atau <kbd class="rounded border border-gray-300 bg-white px-1 font-medium dark:border-gray-600 dark:bg-gray-800">Shift</kbd> untuk memilih beberapa file.</p>
                                <x-input-error :messages="$errors->get('photos.*')" class="mt-2" />

                                <div x-show="files.length" x-cloak class="mt-5 rounded-xl border border-gray-100 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900/50">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-bold text-gray-800 dark:text-gray-200"><span x-text="files.length"></span> foto siap diunggah</p>
                                        <span class="text-xs text-gray-500">Cek sebelum simpan</span>
                                    </div>
                                    <div class="mt-3 grid grid-cols-2 gap-3 sm:grid-cols-4">
                                        <template x-for="file in files" :key="`${file.name}-${file.lastModified}`">
                                            <figure class="overflow-hidden rounded-lg bg-white ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                                                <img :src="URL.createObjectURL(file)" :alt="file.name" class="h-24 w-full object-cover">
                                                <figcaption x-text="file.name" class="truncate px-2 py-1.5 text-xs text-gray-500 dark:text-gray-400"></figcaption>
                                            </figure>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <a href="{{ route('owner.fields.index') }}" class="inline-flex justify-center rounded-lg px-5 py-3 text-sm font-semibold text-gray-600 transition hover:bg-white hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white">Batalkan</a>
                        <x-primary-button class="justify-center rounded-lg bg-indigo-600 px-6 py-3 text-sm normal-case tracking-normal hover:bg-indigo-500">Simpan dan atur jadwal</x-primary-button>
                    </div>
                </div>

                <aside class="lg:sticky lg:top-6 lg:self-start">
                    <div class="overflow-hidden rounded-2xl bg-indigo-950 text-white shadow-xl shadow-indigo-950/10">
                        <div class="border-b border-white/10 px-6 py-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-lime-300">Pratinjau katalog</p>
                            <p class="mt-1 text-sm text-indigo-200">Inilah gambaran ringkas yang akan terlihat oleh penyewa.</p>
                        </div>
                        <div class="p-6">
                            <div class="flex h-36 items-center justify-center overflow-hidden rounded-xl bg-gradient-to-br from-indigo-800 to-violet-700">
                                <template x-if="files.length">
                                    <img :src="URL.createObjectURL(files[0])" alt="Pratinjau foto utama" class="h-full w-full object-cover">
                                </template>
                                <template x-if="!files.length">
                                    <span class="text-4xl">⚽</span>
                                </template>
                            </div>
                            <div class="mt-5">
                                <p x-text="fieldName || 'Nama lapangan Anda'" class="text-xl font-bold"></p>
                                <p x-text="[category || 'Kategori olahraga', location || 'Lokasi'].filter(Boolean).join(' · ')" class="mt-1 text-sm text-indigo-200"></p>
                                <div class="mt-5 flex items-end justify-between border-t border-white/10 pt-4">
                                    <div>
                                        <p class="text-xs text-indigo-300">Mulai dari</p>
                                        <p x-text="money()" class="mt-1 font-bold text-lime-300"></p>
                                        <p class="text-xs text-indigo-300">per jam</p>
                                    </div>
                                    <span :class="status === 'available' ? 'bg-lime-300 text-indigo-950' : 'bg-white/15 text-white'" x-text="status === 'available' ? 'Tersedia' : 'Belum tersedia'" class="rounded-full px-3 py-1.5 text-xs font-bold"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900 dark:border-amber-900/50 dark:bg-amber-950/30 dark:text-amber-100">
                        <p class="font-bold">Langkah berikutnya</p>
                        <p class="mt-1 text-xs leading-5">Setelah lapangan dibuat, Anda akan diarahkan untuk menambahkan jadwal slot operasional.</p>
                    </div>
                </aside>
            </form>
        </div>
    </div>
</x-app-layout>
