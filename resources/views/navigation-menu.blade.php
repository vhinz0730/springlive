<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-center" style="background-image: url('{{ asset('bg.gif') }}');">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl px-4 sm:px-6 lg:px-8 ml-10">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <img class="h-11 w-11 transition-transform duration-500 ease-in-out hover:rotate-[360deg] hover:animate-ping"
                    src="{{ asset('app-logo.png') }}" />
                </div>
                @if( request()->routeIs('admin-department'))
                    <div :active="request()->routeIs('admin-department')"> </div>
                @else
                <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link href="{{ route('home') }}" class="hover:animate-bounce" :active="request()->routeIs('home')" wire:navigate>
                        <i class="fa fa-home"></i>{{ __('Home') }} </span>
                        </x-nav-link>
                        <x-nav-link href="{{ route('projects') }}" class="hover:animate-bounce" :active="request()->routeIs('projects','editor-project')" wire:navigate>
                        <i class="fa-solid fa-laptop-file"></i>{{ __('Projects') }} 
                        </x-nav-link>
                        <x-nav-link href="{{ route('sales') }}" class="hover:animate-bounce" :active="request()->routeIs('sales', 'creator-sales')" wire:navigate>
                        <i class="fa-solid fa-circle-dollar-to-slot"></i>{{ __('Sales') }}
                        </x-nav-link>
                        <x-nav-link href="{{ route('renewal') }}" class="hover:animate-bounce" :active="request()->routeIs('renewal')" wire:navigate>
                        <i class="fa-regular fa-calendar-check"></i>{{ __('Renewal') }}
                        </x-nav-link>
                        
                    </div>
                @endif
            </div>
        
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Settings Dropdown -->
                <div class="ms-3 relative inline-flex">
                <livewire:megaphone></livewire:megaphone>
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">

                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        <i class="fa-solid fa-user"></i>{{ ucwords(Auth::user()->name) }}

                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>
                        <x-slot name="content">
                            @if(Auth::user()->role_id == '1' || Auth::user()->role_id == '0')
                                @if( request()->routeIs('admin-department') )
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Home') }}
                                    </div>
                                    <x-dropdown-link href="{{ route('home') }}" wire:navigate>
                                        <i class="fa fa-home"></i> {{ __('Home') }}
                                    </x-dropdown-link>
                                @else
                                
                                    <!-- User Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Users') }}
                                    </div>
                                    <x-dropdown-link href="{{ route('admin-department') }}" :active="request()->routeIs('admin-department')" wire:navigate>
                                        <i class="fa-solid fa-users-gear"></i> {{ __('Users') }}
                                    </x-dropdown-link>
                                  
                                @endif
                            
                            @endif
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                            <i class="fa-solid fa-user-pen"></i> {{ __('Profile') }}
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-200"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();">
                                    <i class="fa-solid fa-power-off"></i> {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('home') }}" :active="request()->routeIs('dashboard')">
                {{ __('Home') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 me-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}"
                                   @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

                <!-- Team Management -->
               
            </div>
        </div>
    </div>
</nav>
