<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-400">Sparring Matchmaking</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Buat postingan sparring</h2>
            </div>
            <a href="{{ route('dashboard') }}" class="hidden items-center gap-2 text-sm font-semibold text-gray-600 transition hover:text-indigo-600 dark:text-gray-300 sm:inline-flex">
                <span aria-hidden="true">&larr;</span> Kembali ke dashboard
            </a>
        </div>
    </x-slot>

    <div class="bg-gradient-to-b from-indigo-50 via-gray-50 to-gray-100 py-8 dark:from-gray-900 dark:via-gray-900 dark:to-gray-950 sm:py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8" x-data="{
            title: @js(old('title', '')),
            category: @js(old('sport_category', 'Futsal')),
            location: @js(old('location', '')),
            eventDate: @js(old('event_date', '')),
            startTime: @js(old('start_time', '')),
            endTime: @js(old('end_time', '')),
            teamName: @js(old('team_name', '')),
            maxPlayers: @js(old('max_players', 10)),
            cost: @js(old('cost', '')),
            contact: @js(old('contact', ''))
        }">
            @if(session('status'))
                <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 shadow-sm dark:border-emerald-900/60 dark:bg-emerald-950/30 dark:text-emerald-200">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-xs font-bold text-white">✓</span>
                    <p class="pt-0.5 font-medium">{{ session('status') }}</p>
                </div>
            @endif

            <div class="mb-8 grid gap-4 rounded-2xl bg-indigo-950 p-5 text-white shadow-xl shadow-indigo-950/10 sm:grid-cols-[auto_1fr] sm:items-center sm:p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-lime-300 text-xl font-black text-indigo-950">⚔️</div>
                <div>
                    <p class="font-semibold">Ajak tim lain bertanding & temukan lawan sparring sepadan.</p>
                    <p class="mt-1 text-sm text-indigo-200">Isi rincian tim, lokasi, serta jadwal pertandingan. Komunitas pencari sparring dapat mengajukan tantangan ke tim Anda.</p>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">
                <div class="space-y-6">
                    <form method="POST" action="{{ route('sparring.store') }}" class="space-y-6">
                        @csrf

                        <!-- Section 1: Informasi Pertandingan -->
                        <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                            <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:px-8">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">01</span>
                                    <div>
                                        <h3 class="font-bold text-gray-900 dark:text-white">Identitas pertandingan & tim</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Judul ajakan, cabang olahraga, dan nama tim Anda.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid gap-5 p-6 sm:grid-cols-2 sm:p-8">
                                <div class="sm:col-span-2">
                                    <x-input-label for="title" :value="__('Judul postingan sparring')" class="font-semibold" />
                                    <x-text-input id="title" class="mt-2 block w-full" type="text" name="title" x-model="title" placeholder="Contoh: Sparring Futsal Fun Match Weekend" required autofocus />
                                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="sport_category" :value="__('Cabang olahraga')" class="font-semibold" />
                                    <select id="sport_category" name="sport_category" x-model="category" class="mt-2 block w-full rounded-lg border-gray-300 py-2.5 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200" required>
                                        @foreach(['Futsal', 'Badminton', 'Basket', 'Mini Soccer', 'Voli', 'Tenis'] as $option)
                                            <option value="{{ $option }}" @selected(old('sport_category', 'Futsal') === $option)>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('sport_category')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="team_name" :value="__('Nama tim / komunitas')" class="font-semibold" />
                                    <x-text-input id="team_name" class="mt-2 block w-full" type="text" name="team_name" x-model="teamName" placeholder="Contoh: FC Garuda Jakarta" required />
                                    <x-input-error :messages="$errors->get('team_name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="max_players" :value="__('Jumlah maksimal anggota')" class="font-semibold" />
                                    <x-text-input id="max_players" class="mt-2 block w-full" type="number" name="max_players" min="2" max="99" x-model="maxPlayers" placeholder="Contoh: 10" required />
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Kuota tim, termasuk Anda sebagai pembuat (anggota pertama).</p>
                                    <x-input-error :messages="$errors->get('max_players')" class="mt-2" />
                                </div>
                            </div>
                        </section>

                        <!-- Section 2: Waktu & Lokasi -->
                        <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                            <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:px-8">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">02</span>
                                    <div>
                                        <h3 class="font-bold text-gray-900 dark:text-white">Waktu & tempat pertandingan</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Tentukan lokasi/kota dan jadwal bertanding.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid gap-5 p-6 sm:grid-cols-2 sm:p-8">
                                <div>
                                    <x-input-label for="location" :value="__('Kota / lokasi')" class="font-semibold" />
                                    <x-text-input id="location" class="mt-2 block w-full" type="text" name="location" x-model="location" placeholder="Contoh: Jakarta Selatan" required />
                                    <x-input-error :messages="$errors->get('location')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="field_id" :value="__('Pilihan venue / lapangan (opsional)')" class="font-semibold" />
                                    <select id="field_id" name="field_id" class="mt-2 block w-full rounded-lg border-gray-300 py-2.5 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
                                        <option value="">Lainnya / Belum ditentukan</option>
                                        @foreach($fields as $field)
                                            <option value="{{ $field->id }}" @selected(old('field_id') == $field->id)>
                                                {{ $field->field_name }} ({{ $field->sport_category }} - {{ $field->location }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('field_id')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="event_date" :value="__('Tanggal pertandingan')" class="font-semibold" />
                                    <x-text-input id="event_date" type="date" name="event_date" class="mt-2 block w-full" x-model="eventDate" min="{{ date('Y-m-d') }}" required />
                                    <x-input-error :messages="$errors->get('event_date')" class="mt-2" />
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <x-input-label for="start_time" :value="__('Jam mulai')" class="font-semibold" />
                                        <x-text-input id="start_time" type="time" name="start_time" class="mt-2 block w-full" x-model="startTime" required />
                                        <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="end_time" :value="__('Jam selesai')" class="font-semibold" />
                                        <x-text-input id="end_time" type="time" name="end_time" class="mt-2 block w-full" x-model="endTime" required />
                                        <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Section 3: Biaya & Kontak -->
                        <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                            <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:px-8">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">03</span>
                                    <div>
                                        <h3 class="font-bold text-gray-900 dark:text-white">Estimasi biaya & kontak</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Rincian patungan dan nomor komunikasi.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid gap-5 p-6 sm:grid-cols-2 sm:p-8">
                                <div>
                                    <x-input-label for="cost" :value="__('Estimasi biaya / patungan')" class="font-semibold" />
                                    <x-text-input id="cost" class="mt-2 block w-full" type="text" name="cost" x-model="cost" placeholder="Contoh: Patungan Rp 50.000 / tim" />
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Dapat diisi nilai rupiah, patungan 50/50, atau gratis.</p>
                                    <x-input-error :messages="$errors->get('cost')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="contact" :value="__('Nomor kontak / WhatsApp')" class="font-semibold" />
                                    <x-text-input id="contact" class="mt-2 block w-full" type="text" name="contact" x-model="contact" placeholder="Contoh: 081234567890 (Kapten Budi)" required />
                                    <x-input-error :messages="$errors->get('contact')" class="mt-2" />
                                </div>
                            </div>
                        </section>

                        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <a href="{{ route('dashboard') }}" class="inline-flex justify-center rounded-lg px-5 py-3 text-sm font-semibold text-gray-600 transition hover:bg-white hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white">Batalkan</a>
                            <x-primary-button class="justify-center rounded-lg bg-indigo-600 px-6 py-3 text-sm normal-case tracking-normal hover:bg-indigo-500">Publikasikan sparring</x-primary-button>
                        </div>
                    </form>
                </div>

                <!-- Sticky Sidebar Live Preview -->
                <aside class="lg:sticky lg:top-6 lg:self-start">
                    <div class="overflow-hidden rounded-2xl bg-indigo-950 text-white shadow-xl shadow-indigo-950/10">
                        <div class="border-b border-white/10 px-6 py-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-lime-300">Pratinjau Postingan</p>
                            <p class="mt-1 text-sm text-indigo-200">Tampilan postingan sparring Anda di halaman komunitas.</p>
                        </div>
                        <div class="p-6">
                            <div class="flex h-28 items-center justify-center overflow-hidden rounded-xl bg-gradient-to-br from-indigo-800 to-violet-700 p-4 text-center">
                                <div>
                                    <span class="inline-block rounded-full bg-lime-300 px-3 py-1 text-xs font-black uppercase text-indigo-950" x-text="category || 'FUTSAL'"></span>
                                    <p class="mt-2 font-bold text-white text-sm" x-text="teamName || 'Nama Tim Anda'"></p>
                                </div>
                            </div>
                            <div class="mt-5 space-y-3">
                                <div>
                                    <p x-text="title || 'Judul Postingan Sparring'" class="text-lg font-bold text-white leading-snug"></p>
                                    <p x-text="location ? `📍 ${location}` : '📍 Lokasi belum diisi'" class="mt-1 text-xs text-indigo-200"></p>
                                </div>
                                <div class="rounded-xl border border-white/10 bg-white/5 p-3.5 space-y-2 text-xs">
                                    <div class="flex justify-between">
                                        <span class="text-indigo-300">Tanggal:</span>
                                        <span class="font-bold text-white" x-text="eventDate || 'Belum dipilih'"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-indigo-300">Jam:</span>
                                        <span class="font-bold text-white" x-text="(startTime && endTime) ? `${startTime} - ${endTime}` : 'Belum diisi'"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-indigo-300">Biaya:</span>
                                        <span class="font-bold text-lime-300" x-text="cost || 'Gratis / Negotiable'"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-indigo-300">Kontak:</span>
                                        <span class="font-bold text-white" x-text="contact || '-'"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-indigo-300">👥 Anggota:</span>
                                        <span class="font-bold text-lime-300" x-text="'1 / ' + (maxPlayers || 10)"></span>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center pt-2">
                                    <span class="text-xs text-indigo-300">Status Post:</span>
                                    <span class="rounded-full bg-emerald-500/20 text-emerald-300 px-2.5 py-0.5 text-xs font-bold border border-emerald-500/30">OPEN</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900 dark:border-amber-900/50 dark:bg-amber-950/30 dark:text-amber-100">
                        <p class="font-bold">Tips sparring sukses</p>
                        <p class="mt-1 text-xs leading-5">Pastikan nomor kontak aktif (WhatsApp) agar tim calon lawan mudah menghubungi Anda untuk konfirmasi pertandingan.</p>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
