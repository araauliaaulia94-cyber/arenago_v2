<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-400">Owner workspace</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Kelola profil usaha</h2>
            </div>
            <a href="{{ route('owner.dashboard') }}" class="hidden items-center gap-2 text-sm font-semibold text-gray-600 transition hover:text-indigo-600 dark:text-gray-300 sm:inline-flex">
                <span aria-hidden="true">&larr;</span> Kembali ke dashboard pemilik
            </a>
        </div>
    </x-slot>

    <div class="bg-gradient-to-b from-indigo-50 via-gray-50 to-gray-100 py-8 dark:from-gray-900 dark:via-gray-900 dark:to-gray-950 sm:py-12">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8" x-data="{
            namaUsaha: @js(old('nama_usaha', $owner->nama_usaha)),
            kota: @js(old('kota', $owner->kota)),
            alamat: @js(old('alamat_lengkap', $owner->alamat_lengkap)),
            rekening: @js(old('rekening_bank', $owner->rekening_bank)),
            fileName: ''
        }">
            @if(session('status'))
                <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 shadow-sm dark:border-emerald-900/60 dark:bg-emerald-950/30 dark:text-emerald-200">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-xs font-bold text-white">&#10003;</span>
                    <p class="pt-0.5 font-medium">{{ session('status') }}</p>
                </div>
            @endif

            <div class="mb-8 grid gap-4 rounded-2xl bg-indigo-950 p-5 text-white shadow-xl shadow-indigo-950/10 sm:grid-cols-[auto_1fr] sm:items-center sm:p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-lime-300 text-xl font-black text-indigo-950">&#127970;</div>
                <div>
                    <p class="font-semibold">Perbarui informasi venue dan instruksi pembayaran Anda.</p>
                    <p class="mt-1 text-sm text-indigo-200">Informasi ini akan ditampilkan kepada penyewa saat mencari lapangan dan melakukan transaksi.</p>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">
                <form method="POST" action="{{ route('owner.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:px-8">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">01</span>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white">Identitas usaha</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Informasi rujukan utama bagi penyewa.</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid gap-5 p-6 sm:grid-cols-2 sm:p-8">
                            <div class="sm:col-span-2">
                                <x-input-label for="nama_usaha" :value="__('Nama usaha / lapangan')" class="font-semibold" />
                                <x-text-input id="nama_usaha" class="mt-2 block w-full" type="text" name="nama_usaha" x-model="namaUsaha" required autofocus />
                                <x-input-error :messages="$errors->get('nama_usaha')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="kota" :value="__('Kota / kabupaten')" class="font-semibold" />
                                <x-text-input id="kota" class="mt-2 block w-full" type="text" name="kota" x-model="kota" required />
                                <x-input-error :messages="$errors->get('kota')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="rekening_bank" :value="__('Rekening bank')" class="font-semibold" />
                                <x-text-input id="rekening_bank" class="mt-2 block w-full" type="text" name="rekening_bank" x-model="rekening" placeholder="Contoh: BCA 1234567890 a.n. Budi" />
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Ditampilkan sebagai instruksi transfer pada pembayaran booking.</p>
                                <x-input-error :messages="$errors->get('rekening_bank')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-2">
                                <x-input-label for="alamat_lengkap" :value="__('Alamat lengkap usaha')" class="font-semibold" />
                                <textarea id="alamat_lengkap" name="alamat_lengkap" rows="3" class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200" required x-model="alamat"></textarea>
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
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Ganti atau tambahkan foto utama tempat usaha Anda.</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 sm:p-8">
                            @if($owner->foto_usaha)
                                <div class="mb-4 flex items-center gap-4 rounded-xl border border-gray-200 bg-gray-50 p-3 dark:border-gray-700 dark:bg-gray-900">
                                    <img src="{{ asset('storage/' . $owner->foto_usaha) }}" alt="{{ $owner->nama_usaha }}" class="h-16 w-16 rounded-lg object-cover">
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">Foto usaha saat ini</p>
                                        <p class="text-sm font-bold text-gray-900 dark:text-white">Foto tersimpan</p>
                                    </div>
                                </div>
                            @endif

                            <label for="foto_usaha" class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-indigo-200 bg-indigo-50/60 px-6 py-8 text-center transition hover:border-indigo-500 hover:bg-indigo-50 dark:border-indigo-900 dark:bg-indigo-950/30 dark:hover:bg-indigo-950/50">
                                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-lg text-indigo-600 shadow-sm dark:bg-gray-800">&#8533;</span>
                                <span class="mt-2 text-sm font-bold text-indigo-700 dark:text-indigo-300">Pilih foto usaha baru</span>
                                <span class="mt-1 text-xs text-gray-500 dark:text-gray-400">JPG atau PNG &middot; maksimal 2 MB &middot; biarkan kosong jika tidak diubah</span>
                            </label>
                            <input id="foto_usaha" type="file" name="foto_usaha" accept="image/*" class="sr-only" @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''">
                            <p x-show="fileName" x-cloak x-text="fileName" class="mt-3 truncate text-xs font-semibold text-indigo-600 dark:text-indigo-400"></p>
                            <x-input-error :messages="$errors->get('foto_usaha')" class="mt-2" />
                        </div>
                    </section>

                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <a href="{{ route('owner.dashboard') }}" class="inline-flex justify-center rounded-lg px-5 py-3 text-sm font-semibold text-gray-600 transition hover:bg-white hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white">Batal</a>
                        <button type="submit" class="inline-flex justify-center rounded-lg bg-indigo-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-indigo-500">Simpan perubahan</button>
                    </div>
                </form>

                <aside class="lg:sticky lg:top-6 lg:self-start">
                    <section class="overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <h4 class="font-bold text-gray-900 dark:text-white">Ringkasan profil</h4>
                        <dl class="mt-4 space-y-3 text-sm">
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wider text-gray-400">Status verifikasi</dt>
                                <dd class="mt-1 inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20 dark:bg-emerald-950/40 dark:text-emerald-300">
                                    {{ ucfirst($owner->status_verifikasi ?? 'Aktif') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wider text-gray-400">Jumlah lapangan</dt>
                                <dd class="mt-1 font-bold text-gray-900 dark:text-white">{{ $owner->fields()->count() }} Lapangan</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wider text-gray-400">Terdaftar sejak</dt>
                                <dd class="mt-1 text-gray-700 dark:text-gray-300">{{ $owner->created_at->format('d M Y') }}</dd>
                            </div>
                        </dl>
                        <div class="mt-6 border-t border-gray-100 pt-4 dark:border-gray-700">
                            <a href="{{ route('owner.fields.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 dark:text-indigo-300">
                                Kelola daftar lapangan <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    </section>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
