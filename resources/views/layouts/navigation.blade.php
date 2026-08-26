<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-white/80 backdrop-blur-md dark:bg-gray-900/80 border-b border-slate-100 dark:border-gray-800/80 transition-all duration-200">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <!-- Logo & Brand Name -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group transition-transform duration-200 hover:scale-[1.02]">
                        <span class="text-lg font-black tracking-wider text-slate-900 dark:text-white animate-pulse">ARENA<span class="text-indigo-600 dark:text-indigo-400">GO</span></span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:flex sm:items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="px-3.5 py-2 text-sm font-semibold rounded-lg transition-all">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('fields.index')" :active="request()->routeIs('fields.*')" class="px-3.5 py-2 text-sm font-semibold rounded-lg transition-all">
                        {{ __('Jelajahi Lapangan') }}
                    </x-nav-link>

                    <x-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.*')" class="px-3.5 py-2 text-sm font-semibold rounded-lg transition-all">
                        {{ __('Pesanan Saya') }}
                    </x-nav-link>

                    <x-nav-link :href="route('sparring.create')" :active="request()->routeIs('sparring.*')" class="px-3.5 py-2 text-sm font-semibold rounded-lg transition-all">
                        {{ __('Buat Sparring') }}
                    </x-nav-link>

                    @if(Auth::user()->isOwner())
                        <x-nav-link :href="route('owner.dashboard')" :active="request()->routeIs('owner.*')" class="px-3.5 py-2 text-sm font-semibold rounded-lg transition-all text-indigo-600 dark:text-indigo-400">
                            <span class="flex items-center gap-1.5">
                                <span class="h-2 w-2 rounded-full bg-indigo-500 animate-pulse"></span>
                                {{ __('Dashboard Pemilik') }}
                            </span>
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2.5 px-3 py-1.5 border border-slate-200/80 dark:border-gray-700/80 text-sm font-medium rounded-full text-slate-700 dark:text-gray-200 bg-white/90 dark:bg-gray-800/90 hover:bg-slate-50 dark:hover:bg-gray-700/70 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition duration-150 shadow-sm">
                            <div class="flex h-7 w-7 items-center justify-center rounded-full bg-gradient-to-tr from-indigo-500 to-indigo-700 text-xs font-bold text-white uppercase shadow-sm">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="flex flex-col text-left">
                                <span class="text-xs font-bold leading-tight text-slate-800 dark:text-white max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] leading-tight text-slate-500 dark:text-gray-400 flex items-center gap-1">
                                    @if(Auth::user()->isOwner())
                                        <span class="font-bold text-indigo-600 dark:text-indigo-400">Owner</span>
                                    @else
                                        <span>Penyewa</span>
                                    @endif
                                </span>
                            </div>

                            <svg class="h-4 w-4 text-slate-400 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-slate-100 dark:border-gray-700/60 bg-slate-50/50 dark:bg-gray-800/50 rounded-t-lg">
                            <p class="text-xs text-slate-500 dark:text-gray-400">Login sebagai</p>
                            <p class="text-sm font-bold text-slate-900 dark:text-white truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <div class="py-1">
                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2 px-4 py-2 text-xs font-semibold text-slate-700 dark:text-gray-300 hover:bg-slate-50 dark:hover:bg-gray-700">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ __('Pengaturan Akun') }}
                            </x-dropdown-link>

                            @if(Auth::user()->isOwner())
                                <x-dropdown-link :href="route('owner.profile.edit')" class="flex items-center gap-2 px-4 py-2 text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50/50 dark:hover:bg-indigo-950/30">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    {{ __('Profil Usaha Owner') }}
                                </x-dropdown-link>
                            @endif
                        </div>

                        <div class="border-t border-slate-100 dark:border-gray-700/60 py-1">
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        class="flex items-center gap-2 px-4 py-2 text-xs font-semibold text-rose-600 dark:text-rose-400 hover:bg-rose-50/50 dark:hover:bg-rose-950/30"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger Button (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2.5 rounded-xl text-slate-500 dark:text-gray-400 hover:text-slate-700 dark:hover:text-gray-200 hover:bg-slate-100 dark:hover:bg-gray-800 focus:outline-none transition duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile Drawer) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white dark:bg-gray-900 border-b border-slate-200 dark:border-gray-800">
        <div class="pt-3 pb-4 space-y-1 px-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="rounded-xl px-4 py-2.5 font-semibold">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('fields.index')" :active="request()->routeIs('fields.*')" class="rounded-xl px-4 py-2.5 font-semibold">
                {{ __('Jelajahi Lapangan') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.*')" class="rounded-xl px-4 py-2.5 font-semibold">
                {{ __('Pesanan Saya') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('sparring.create')" :active="request()->routeIs('sparring.*')" class="rounded-xl px-4 py-2.5 font-semibold">
                {{ __('Buat Sparring') }}
            </x-responsive-nav-link>

            @if(Auth::user()->isOwner())
                <x-responsive-nav-link :href="route('owner.dashboard')" :active="request()->routeIs('owner.*')" class="rounded-xl px-4 py-2.5 font-semibold text-indigo-600 dark:text-indigo-400">
                    {{ __('Dashboard Pemilik') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-4 border-t border-slate-100 dark:border-gray-800 bg-slate-50/50 dark:bg-gray-800/30 px-4">
            <div class="flex items-center gap-3 px-2 mb-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-600 text-sm font-bold text-white uppercase shadow-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-bold text-sm text-slate-900 dark:text-white flex items-center gap-2">
                        <span>{{ Auth::user()->name }}</span>
                        @if(Auth::user()->isOwner())
                            <span class="rounded bg-indigo-100 px-1.5 py-0.5 text-[10px] font-bold text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">Owner</span>
                        @endif
                    </div>
                    <div class="font-medium text-xs text-slate-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="rounded-lg px-4 py-2 text-xs font-semibold">
                    {{ __('Pengaturan Akun') }}
                </x-responsive-nav-link>

                @if(Auth::user()->isOwner())
                    <x-responsive-nav-link :href="route('owner.profile.edit')" class="rounded-lg px-4 py-2 text-xs font-semibold text-indigo-600 dark:text-indigo-400">
                        {{ __('Profil Usaha Owner') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            class="rounded-lg px-4 py-2 text-xs font-semibold text-rose-600 dark:text-rose-400"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
