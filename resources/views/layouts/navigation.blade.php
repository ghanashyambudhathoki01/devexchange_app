<nav x-data="{ open: false }" class="bg-white border-b border-slate-100 shadow-sm sticky top-0 z-50 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-indigo-200 shadow-lg group-hover:scale-110 transition-all duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        </div>
                        <span class="text-xl font-black text-slate-900 tracking-tight">Dev<span class="text-indigo-600">Exchange</span></span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Questions') }}
                    </x-nav-link>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
                                {{ __('Admin Console') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">
                @auth
                    <!-- Notifications -->
                    <a href="{{ route('notifications.index') }}" class="relative p-2 text-slate-400 hover:text-indigo-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute top-0 right-0 w-2 h-2 bg-rose-500 rounded-full border-2 border-white"></span>
                        @endif
                    </a>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-4 py-2 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-700 hover:bg-slate-100 transition-all duration-200">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 bg-indigo-100 text-indigo-600 rounded-md flex items-center justify-center text-[10px]">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    {{ Auth::user()->name }}
                                </div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 border-b border-slate-50">
                                <span class="block text-xs text-slate-400 font-bold uppercase tracking-wider">Reputation</span>
                                <span class="text-sm font-black text-indigo-600">{{ auth()->user()->reputation }} pts</span>
                            </div>
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('My Profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-rose-600">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-indigo-600 transition-colors">Sign In</a>
                        <a href="{{ route('register') }}" class="btn-primary py-2 px-5 text-sm">Create Account</a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-slate-50 border-t border-slate-100">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Questions') }}
            </x-responsive-nav-link>
        </div>
        @auth
            <div class="pt-4 pb-1 border-t border-slate-200">
                <div class="px-4 flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-bold text-slate-900">{{ Auth::user()->name }}</div>
                        <div class="text-xs font-medium text-indigo-600">{{ auth()->user()->reputation }} pts</div>
                    </div>
                </div>
                <div class="space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profile') }}</x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-rose-600">{{ __('Log Out') }}</x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="p-4 space-y-2">
                <a href="{{ route('login') }}" class="block text-center py-3 font-bold text-slate-600">Sign In</a>
                <a href="{{ route('register') }}" class="block text-center py-3 btn-primary">Create Account</a>
            </div>
        @endauth
    </div>
</nav>
