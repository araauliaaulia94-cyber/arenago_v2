<x-app-layout>
    @php
        $availableFields = $fields->where('status', 'available')->count();
        $unavailableFields = $fields->where('status', 'unavailable')->count();
        $totalPhotos = $fields->sum(fn ($field) => $field->photos->count());
    @endphp

    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-400">Owner workspace</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Dashboard pemilik</h2>
            </div>
            <a href="{{ route('owner.fields.index') }}" class="hidden items-center gap-2 text-sm font-semibold text-gray-600 transition hover:text-indigo-600 dark:text-gray-300 sm:inline-flex">
                Kelola lapangan saya <span aria-hidden="true">&rarr;</span>
            </a>
        </div>
    </x-slot>

    <div class="bg-gradient-to-b from-indigo-50 via-gray-50 to-gray-100 py-8 dark:from-gray-900 dark:via-gray-900 dark:to-gray-950 sm:py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 shadow-sm dark:border-emerald-900/60 dark:bg-emerald-950/30 dark:text-emerald-200">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-xs font-bold text-white">&#10003;</span>
                    <p class="pt-0.5 font-medium">{{ session('status') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800 shadow-sm dark:border-red-900/60 dark:bg-red-950/30 dark:text-red-200">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-red-600 text-xs font-bold text-white">!</span>
                    <p class="pt-0.5 font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <div class="mb-8 flex flex-col gap-5 rounded-2xl bg-indigo-950 p-6 text-white shadow-xl shadow-indigo-950/10 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-lime-300">Pusat kendali venue</p>
                    <h3 class="mt-2 text-2xl font-bold">Kelola venue Anda dalam satu tempat.</h3>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-indigo-200">Perbarui detail dan galeri lapangan, lalu buka slot jadwal agar penyewa mendapatkan informasi yang selalu akurat.</p>
                </div>
                @if($needsAction > 0)
                    <a href="{{ route('owner.bookings') }}" class="inline-flex w-fit items-center gap-2 rounded-full bg-amber-300 px-4 py-2 text-sm font-bold text-amber-950 transition hover:bg-amber-200">
                        {{ $needsAction }} perlu konfirmasi <span aria-hidden="true">&rarr;</span>
                    </a>
                @else
                    <a href="{{ route('owner.bookings') }}" class="inline-flex w-fit items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/20">
                        Pesanan masuk <span aria-hidden="true">&rarr;</span>
                    </a>
                @endif
            </div>

            <section class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4" aria-label="Ringkasan venue">
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total lapangan</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $fields->count() }}</p>
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 text-lg text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">&#9962;</span>
                    </div>
                </div>
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tersedia di katalog</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold tracking-tight text-emerald-600 dark:text-emerald-400">{{ $availableFields }}</p>
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-lg text-emerald-700 dark:bg-emerald-900 dark:text-emerald-200">&#10003;</span>
                    </div>
                </div>
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Foto galeri</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $totalPhotos }}</p>
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-100 text-lg text-violet-700 dark:bg-violet-900 dark:text-violet-200">&#128436;</span>
                    </div>
                </div>
                <a href="{{ route('owner.bookings') }}" class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200 transition hover:shadow-md hover:shadow-indigo-950/5 dark:bg-gray-800 dark:ring-gray-700">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Perlu konfirmasi</p>
                    <div class="mt-3 flex items-end justify-between">
                        <p class="text-3xl font-bold tracking-tight text-amber-600 dark:text-amber-400">{{ $needsAction }}</p>
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-lg text-amber-700 dark:bg-amber-900 dark:text-amber-200">&#9203;</span>
                    </div>
                </a>
            </section>

            <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                <div class="flex flex-col gap-3 border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:flex-row sm:items-center sm:justify-between sm:px-8">
                    <div class="flex items-center gap-3">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-violet-100 text-sm font-bold text-violet-700 dark:bg-violet-900 dark:text-violet-200">01</span>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white">Kelola venue</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Pembaruan lapangan dan slot jadwal memengaruhi ketersediaan di katalog.</p>
                        </div>
                    </div>
                    @if($unavailableFields > 0)
                        <span class="w-fit rounded-full bg-amber-50 px-3 py-1 text-xs font-bold text-amber-700 dark:bg-amber-950/40 dark:text-amber-300">{{ $unavailableFields }} belum tersedia</span>
                    @endif
                </div>
                <div class="grid gap-4 p-6 sm:p-8 md:grid-cols-2 xl:grid-cols-3">
                    <a href="{{ route('owner.fields.index') }}" class="group rounded-2xl border border-gray-200 bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-indigo-950/10 dark:border-gray-700 dark:bg-gray-900">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 text-lg text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">&#9962;</span>
                        <h4 class="mt-3 font-bold text-gray-900 dark:text-white">Lapangan saya</h4>
                        <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">Tambah, edit, atau hapus lapangan dan kelola galeri foto.</p>
                        <p class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-indigo-600 dark:text-indigo-300">Buka <span class="transition group-hover:translate-x-1" aria-hidden="true">&rarr;</span></p>
                    </a>
                    <a href="{{ route('owner.fields.index') }}" class="group rounded-2xl border border-gray-200 bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-indigo-950/10 dark:border-gray-700 dark:bg-gray-900">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-lg text-emerald-700 dark:bg-emerald-900 dark:text-emerald-200">&#9201;</span>
                        <h4 class="mt-3 font-bold text-gray-900 dark:text-white">Slot jadwal</h4>
                        <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">Atur jam operasional dan slot waktu setiap lapangan dari daftar lapangan.</p>
                        <p class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-indigo-600 dark:text-indigo-300">Atur jadwal <span class="transition group-hover:translate-x-1" aria-hidden="true">&rarr;</span></p>
                    </a>
                    <a href="{{ route('owner.bookings') }}" class="group rounded-2xl border border-gray-200 bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-indigo-950/10 dark:border-gray-700 dark:bg-gray-900">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-lg text-amber-700 dark:bg-amber-900 dark:text-amber-200">&#9993;</span>
                        <h4 class="mt-3 font-bold text-gray-900 dark:text-white">Pesanan masuk</h4>
                        <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">Tinjau bukti bayar dan konfirmasi pesanan penyewa pada halaman khusus.</p>
                        @if($needsAction > 0)
                            <p class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-amber-600 dark:text-amber-300">{{ $needsAction }} perlu konfirmasi <span class="transition group-hover:translate-x-1" aria-hidden="true">&rarr;</span></p>
                        @else
                            <p class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-indigo-600 dark:text-indigo-300">Buka <span class="transition group-hover:translate-x-1" aria-hidden="true">&rarr;</span></p>
                        @endif
                    </a>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>