<div x-data="{ open: false }" class="bg-white shadow sticky top-0 z-50 h-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between">
            <div class="flex">
                <div class="-ml-2 mr-2 flex items-center md:hidden">
                    <!-- Mobile menu button -->
                    <button @click="open = !open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7" />
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex-shrink-0 flex items-center">
                    <a href={{ route('home') }}>
                        <img alt="logo" class="h-16 w-16 md:h-[5rem] md:w-[5rem]"
                            src="{{ asset('logo.svg') }}" /></a>
                </div>
            </div>
            <div class="hidden md:flex md:items-center md:space-x-4">
                @auth
                    @if (Auth::user()->role === 'customer')
                        <a href="/cart"
                            class="rounded-full hover:border-green-600 hover:text-green-600 border border-transparent block p-2"
                            wire:navigate>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-shopping-basket h-6 w-6">
                                <path d="m15 11-1 9" />
                                <path d="m19 11-4-7" />
                                <path d="M2 11h20" />
                                <path d="m3.5 11 1.6 7.4a2 2 0 0 0 2 1.6h9.8a2 2 0 0 0 2-1.6l1.7-7.4" />
                                <path d="M4.5 15.5h15" />
                                <path d="m5 11 4-7" />
                                <path d="m9 11 1 9" />
                            </svg></a>
                    @endif
                    <a href="/profile" class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium"
                        wire:navigate>Profile</a>
                    <button class="hover:text-white px-3 py-2 rounded-md text-sm font-medium text-red-500 hover:bg-red-500"
                        wire:click="logout">Logout</button>
                @else
                    <a href={{ route('login') }}
                        class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium"
                        wire:navigate>Login</a>
                    <a href={{ route('register') }}
                        class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium"
                        wire:navigate>Register</a>
                @endauth
            </div>
        </div>
    </div>

    <div :class="{ 'block': open, 'hidden': !open }" class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href={{ route('home') }}
                class="text-gray-500 hover:text-gray-700 block px-3 py-2 rounded-md text-base font-medium"
                wire:navigate>Home</a>
            @auth
                <a href="/profile"
                    class="text-gray-500 hover:text-gray-700 block px-3 py-2 rounded-md text-base font-medium"
                    wire:navigate>Profile</a>
                <button
                    class="w-full text-left hover:text-white block px-3 py-2 rounded-md text-base font-medium text-red-500 hover:bg-red-500"
                    wire:click="logout">Logout</button>
            @else
                <a href={{ route('login') }}
                    class="text-gray-500 hover:text-gray-700 block px-3 py-2 rounded-md text-base font-medium"
                    wire:navigate>Login</a>
                <a href={{ route('register') }}
                    class="text-gray-500 hover:text-gray-700 block px-3 py-2 rounded-md text-base font-medium"
                    wire:navigate>Register</a>
            @endauth
        </div>
    </div>
</div>
