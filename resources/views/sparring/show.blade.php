<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-400">Detail Post Sparring</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $sparringPost->title }}</h2>
            </div>
            <a href="{{ route('sparring.index') }}" class="hidden items-center gap-2 text-sm font-semibold text-gray-600 transition hover:text-indigo-600 dark:text-gray-300 sm:inline-flex">
                <span aria-hidden="true">&larr;</span> Kembali ke cari sparring
            </a>
        </div>
    </x-slot>

    <div class="bg-gradient-to-b from-indigo-50 via-gray-50 to-gray-100 py-8 dark:from-gray-900 dark:via-gray-900 dark:to-gray-950 sm:py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 shadow-sm dark:border-emerald-900/60 dark:bg-emerald-950/30 dark:text-emerald-200">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-xs font-bold text-white">✓</span>
                    <p class="pt-0.5 font-medium">{{ session('status') }}</p>
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_340px]">
                <div class="space-y-6">
                    <!-- Main Post Info Card -->
                    <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="border-b border-gray-100 px-6 py-6 dark:border-gray-700 sm:px-8">
                            <div class="flex items-center justify-between gap-4">
                                <span class="rounded-full bg-indigo-100 px-3.5 py-1 text-xs font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200 uppercase">
                                    {{ $sparringPost->sport_category }}
                                </span>
                                @php
                                    $statusBadge = match ($sparringPost->status) {
                                        'full' => ['PENUH', 'bg-rose-500/15 text-rose-700 dark:bg-rose-950/60 dark:text-rose-300 border border-rose-500/30'],
                                        'matched' => ['MATCHED', 'bg-amber-500/15 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300 border border-amber-500/30'],
                                        default => ['OPEN', 'bg-emerald-500/15 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-500/30'],
                                    };
                                @endphp
                                <span class="rounded-full px-3 py-1 text-xs font-bold uppercase {{ $statusBadge[1] }}">
                                    {{ $statusBadge[0] }}
                                </span>
                            </div>
                            <h1 class="mt-4 text-2xl font-bold text-gray-900 dark:text-white sm:text-3xl">
                                {{ $sparringPost->title }}
                            </h1>
                            <p class="mt-1 text-sm font-semibold text-indigo-600 dark:text-indigo-400">
                                Host Tim: {{ $sparringPost->team_name }} (Dibuat oleh {{ $sparringPost->user->name }})
                            </p>
                        </div>

                        <div class="p-6 sm:p-8">
                            <h3 class="font-bold text-gray-900 dark:text-white text-base">Rincian Pertandingan</h3>
                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900/50">
                                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">📍 Lokasi / Kota</p>
                                    <p class="mt-1 font-bold text-gray-900 dark:text-white text-sm">{{ $sparringPost->location }}</p>
                                </div>
                                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900/50">
                                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">📅 Tanggal Pertandingan</p>
                                    <p class="mt-1 font-bold text-gray-900 dark:text-white text-sm">{{ $sparringPost->event_date->format('l, d F Y') }}</p>
                                </div>
                                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900/50">
                                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">⏰ Jam Main</p>
                                    <p class="mt-1 font-bold text-gray-900 dark:text-white text-sm">{{ substr($sparringPost->start_time, 0, 5) }} – {{ substr($sparringPost->end_time, 0, 5) }} WIB</p>
                                </div>
                                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900/50">
                                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">💰 Estimasi Biaya / Patungan</p>
                                    <p class="mt-1 font-bold text-emerald-600 dark:text-emerald-400 text-sm">{{ $sparringPost->cost ?? 'Gratis / Negotiable' }}</p>
                                </div>
                                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900/50">
                                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">👥 Jumlah Anggota Tim</p>
                                    <p class="mt-1 font-bold text-gray-900 dark:text-white text-sm">{{ $sparringPost->members_count ?? 0 }} / {{ $sparringPost->max_players }}</p>
                                </div>
                            </div>

                            @if($sparringPost->field)
                                <div class="mt-6 rounded-xl border border-indigo-100 bg-indigo-50/50 p-4 dark:border-indigo-900/50 dark:bg-indigo-950/30">
                                    <p class="text-xs font-semibold uppercase tracking-wider text-indigo-700 dark:text-indigo-300">🏟 Venue Lapangan Terdaftar</p>
                                    <div class="mt-2 flex items-center justify-between gap-4">
                                        <div>
                                            <p class="font-bold text-gray-900 dark:text-white">{{ $sparringPost->field->field_name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $sparringPost->field->location }} · Rp {{ number_format($sparringPost->field->price_per_hour, 0, ',', '.') }}/jam</p>
                                        </div>
                                        <a href="{{ route('fields.show', $sparringPost->field) }}" class="rounded-lg bg-indigo-600 px-3 py-1.5 text-xs font-bold text-white transition hover:bg-indigo-500">
                                            Lihat Venue &rarr;
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </section>

                    <!-- Ajukan Sparring (Sparring Invite) -->
                    @if($sparringPost->user_id === auth()->id())
                        <div class="rounded-2xl border border-indigo-100 bg-indigo-50/50 p-5 dark:border-indigo-900/50 dark:bg-indigo-950/30">
                            <p class="text-sm font-semibold text-indigo-700 dark:text-indigo-300">⚔️ Ini adalah postingan milik Anda.</p>
                            <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">Anda tidak dapat mengirim tantangan ke postingan sendiri. Kunjungi postingan tim lain untuk mengajukan sparring.</p>
                        </div>
                    @elseif(! in_array($sparringPost->status, ['open', 'full']))
                        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">Postingan ini tidak menerima tantangan baru.</p>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Status saat ini: <span class="font-bold uppercase">{{ $statusBadge[0] }}</span>. Silakan cari postingan sparring lain yang masih open.</p>
                        </div>
                    @else
                        <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                            <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:px-8">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">⚔️</span>
                                    <div>
                                        <h3 class="font-bold text-gray-900 dark:text-white">Ajukan tantangan sparring</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Kirim ajakan bertanding ke tim {{ $sparringPost->team_name }}.</p>
                                    </div>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('sparring.invites.store', $sparringPost) }}" class="space-y-5 p-6 sm:p-8">
                                @csrf

                                <div>
                                    <x-input-label for="team_name" :value="__('Nama tim Anda')" class="font-semibold" />
                                    <x-text-input id="team_name" class="mt-2 block w-full" type="text" name="team_name" :value="old('team_name')" placeholder="Contoh: FC Garuda Jakarta" required autofocus />
                                    <x-input-error :messages="$errors->get('team_name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="message" :value="__('Pesan tantangan (opsional)')" class="font-semibold" />
                                    <textarea id="message" name="message" rows="4" class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200" placeholder="Contoh: Kami tim dari komunitas Garuda, tertarik main fun match minggu ini. Bisa?">{{ old('message') }}</textarea>
                                    <x-input-error :messages="$errors->get('message')" class="mt-2" />
                                </div>

                                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Host akan menerima pemberitahuan tantangan Anda.</p>
                                    <x-primary-button class="justify-center rounded-lg bg-indigo-600 px-6 py-3 text-sm normal-case tracking-normal hover:bg-indigo-500">Kirim Tantangan</x-primary-button>
                                </div>
                            </form>
                        </section>
                    @endif
                </div>

                <!-- Host Contact Sidebar Card -->
                <aside class="lg:sticky lg:top-6 lg:self-start space-y-4">
                    <div class="overflow-hidden rounded-2xl bg-indigo-950 text-white shadow-xl shadow-indigo-950/10 p-6">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-lime-300">Kontak Tim Host</p>
                        <p class="mt-1 text-xl font-bold">{{ $sparringPost->team_name }}</p>
                        <p class="mt-0.5 text-xs text-indigo-200">Host oleh {{ $sparringPost->user->name }}</p>

                        <div class="mt-6 rounded-xl border border-white/10 bg-white/10 p-4">
                            <p class="text-xs text-indigo-200">Hubungi via WhatsApp/Telepon:</p>
                            <p class="mt-1 text-lg font-bold text-lime-300">{{ $sparringPost->contact }}</p>
                        </div>

                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $sparringPost->contact) }}" target="_blank" class="mt-4 flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-emerald-500">
                            💬 Hubungi via WhatsApp
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
