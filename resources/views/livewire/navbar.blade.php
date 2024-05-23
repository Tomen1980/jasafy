<div x-data="{ open: false }" class="bg-white shadow sticky top-0 z-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
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
                    <a href="/" wire:navigate.hover>
                        <img alt="logo" class="h-16 w-16 md:h-[5rem] md:w-[5rem]"
                            src="{{ asset('logo.svg') }}" /></a>
                </div>
            </div>
            <div class="hidden md:flex md:items-center md:space-x-4">
                <a href="/"
                    class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium" wire:navigate.hover>Home</a>
                @if (Auth::check())
                    <a href="/dashboard"
                        class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium" wire:navigate.hover>Dashboard</a>
                    <button wire:click="logout"
                        class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium" wire:navigate.hover>Logout</button>
                @else
                    <a href="/login"
                        class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium" wire:navigate.hover>Login</a>
                    <a href="/register"
                        class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium" wire:navigate.hover>Register</a>
                @endif
            </div>
        </div>
    </div>

    <div :class="{ 'block': open, 'hidden': !open }" class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="/"
                class="text-gray-500 hover:text-gray-700 block px-3 py-2 rounded-md text-base font-medium" wire:navigate.hover>Home</a>
            @if (Auth::check())
                <a href="/dashboard"
                    class="text-gray-500 hover:text-gray-700 block px-3 py-2 rounded-md text-base font-medium" wire:navigate.hover>Dashboard</a>
                <button wire:click="logout"
                    class="w-full text-left text-gray-500 hover:text-gray-700 block px-3 py-2 rounded-md text-base font-medium">Logout</button>
            @else
                <a href="/login"
                    class="text-gray-500 hover:text-gray-700 block px-3 py-2 rounded-md text-base font-medium" wire:navigate.hover>Login</a>
                <a href="/register"
                    class="text-gray-500 hover:text-gray-700 block px-3 py-2 rounded-md text-base font-medium" wire:navigate.hover>Register</a>
            @endif
        </div>
    </div>
</div>
