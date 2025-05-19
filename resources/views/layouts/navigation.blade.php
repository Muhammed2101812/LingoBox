<nav x-data="{ open: false }" class="bg-emerald-600 border-b border-emerald-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-white" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-emerald-100 hover:text-white focus:text-white">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('translate.lists.index')" :active="request()->routeIs('translate.lists.*')" class="text-emerald-100 hover:text-white focus:text-white">
                        {{ __('Listelerim') }}
                    </x-nav-link>
                    <x-nav-link :href="route('translate.index')" :active="request()->routeIs('translate.index')" class="text-emerald-100 hover:text-white focus:text-white">
                        {{ __('Çeviri Aracı') }}
                    </x-nav-link>
                    <x-nav-link :href="route('flashcards.index')" :active="request()->routeIs('flashcards.*')" class="text-emerald-100 hover:text-white focus:text-white">
                        {{ __('Kelime Kartları') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-emerald-100 bg-emerald-600 hover:text-white focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-emerald-500">
                            <x-dropdown-link :href="route('profile.edit')" class="text-white hover:bg-emerald-400">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                    this.closest('form').submit();"
                                        class="text-white hover:bg-emerald-400">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-emerald-100 hover:text-white hover:bg-emerald-500 focus:outline-none focus:bg-emerald-500 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div x-show="open"
         x-transition:enter="transition ease-in-out duration-300 transform"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in-out duration-300 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed inset-y-0 right-0 w-3/4 max-w-xs sm:max-w-sm p-4 overflow-y-auto bg-emerald-600 shadow-xl z-50 sm:hidden"
         @click.away="open = false"
         x-cloak
    >
        <div class="flex justify-between items-center mb-4">
            <span class="text-lg font-semibold text-white">{{ __('Menu') }}</span>
            <button @click="open = false" class="text-emerald-100 hover:text-white">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-emerald-100 hover:text-white hover:bg-emerald-500">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('translate.lists.index')" :active="request()->routeIs('translate.lists.*')" class="text-emerald-100 hover:text-white hover:bg-emerald-500">
                {{ __('Listelerim') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('translate.index')" :active="request()->routeIs('translate.index')" class="text-emerald-100 hover:text-white hover:bg-emerald-500">
                {{ __('Çeviri Aracı') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('flashcards.index')" :active="request()->routeIs('flashcards.*')" class="text-emerald-100 hover:text-white hover:bg-emerald-500">
                {{ __('Kelime Kartları') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-emerald-500">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-emerald-200">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-emerald-100 hover:text-white hover:bg-emerald-500">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                            class="text-emerald-100 hover:text-white hover:bg-emerald-500">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
