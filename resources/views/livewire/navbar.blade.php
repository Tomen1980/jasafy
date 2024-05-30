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
                    <a href={{ route('home') }} wire:navigate>
                        <img alt="logo" class="h-16 w-16 md:h-[5rem] md:w-[5rem]"
                            src="{{ asset('logo.svg') }}" /></a>
                    <a class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium hidden md:block"
                        href={{ route('services') }} wire:navigate>Services</a>
                    <a class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium hidden md:block" href={{ route("customer-health") }} wire:navigate>Customer Health</a>
                </div>
            </div>
            <div class="hidden md:flex md:items-center md:space-x-4">
                @auth
                    @if (Auth::user()->role === 'customer')
                        <a href={{ route('my-wishlist') }}
                            class="rounded-full hover:border-pink-600 hover:text-pink-600 border border-transparent block p-2 transition ease-out"
                            wire:navigate>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-heart h-6 w-6">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                            </svg>
                        </a>
                        <a href={{ route('cart-manager') }}
                            class="rounded-full hover:border-green-600 hover:text-green-600 border border-transparent block p-2 transition ease-out"
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
                        <a class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium"
                            href={{ route('my-orders') }} wire:navigate>My orders</a>
                    @elseif (Auth::user()->role === 'seller')
                        <a class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium"
                            href={{ route('orders') }}>Orders</a>
                    @endif
                    <a href={{ route('profile') }}
                        class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium"
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

    <div class="bg-white shadow" :class="{ 'block': open, 'hidden': !open }" class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href={{ route('home') }}
                class="text-gray-500 hover:text-gray-700 block px-3 py-2 rounded-md text-base font-medium"
                wire:navigate>Home</a>
            <a class="text-gray-500 hover:text-gray-700 block px-3 py-2 rounded-md text-base font-medium"
                href={{ route('services') }}>Services</a>
            @auth
                @if (Auth::user()->role === 'customer')
                    <a href={{ route('my-wishlist') }}
                        class="text-gray-500 hover:text-gray-700 block px-3 py-2 rounded-md text-base font-medium"
                        wire:navigate>My wishlist</a>
                    <a href={{ route('my-orders') }}
                        class="text-gray-500 hover:text-gray-700 block px-3 py-2 rounded-md text-base font-medium"
                        wire:navigate>My
                        orders</a>
                    <a href={{ route('cart-manager') }}
                        class="text-gray-500 hover:text-gray-700 block px-3 py-2 rounded-md text-base font-medium"
                        wire:navigate>My cart</a>
                @else
                    <a href={{ route('orders') }}
                        class="text-gray-500 hover:text-gray-700 block px-3 py-2 rounded-md text-base font-medium"
                        wire:navigate>Orders</a>
                @endif
                <a href={{ route('profile') }}
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
