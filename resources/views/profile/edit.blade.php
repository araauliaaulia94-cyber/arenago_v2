<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-400">Akun & Keamanan</p>
            <h2 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Pengaturan akun</h2>
        </div>
    </x-slot>

    <div class="bg-gradient-to-b from-indigo-50 via-gray-50 to-gray-100 py-8 dark:from-gray-900 dark:via-gray-900 dark:to-gray-950 sm:py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
            <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:px-8">
                    <div class="flex items-center gap-3">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">01</span>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white">Informasi profil</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Perbarui nama, email, dan foto profil Anda.</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </section>

            <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:px-8">
                    <div class="flex items-center gap-3">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200">02</span>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white">Keamanan sandi</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Pastikan akun Anda tetap aman dengan sandi yang kuat.</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </section>

            <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-700 sm:px-8">
                    <div class="flex items-center gap-3">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-rose-100 text-sm font-bold text-rose-700 dark:bg-rose-900 dark:text-rose-200">⚠</span>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white">Hapus akun</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Hapus akun dan seluruh data secara permanen.</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
