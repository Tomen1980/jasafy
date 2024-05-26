@section('title', 'Sign in to your account')

<div class="grid grid-cols-1 md:grid-cols-2 h-[calc(100vh-5rem)] bg-gray-100">
    <div class="flex flex-col items-center h-full justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Sign in to your account</h2>
            <form class="mt-8 space-y-6" wire:submit.prevent="authenticate">
                <div class="rounded-md -space-y-px">
                    <div>
                        <label for="email" class="sr-only">Email address</label>
                        <input id="email" name="email" type="email" wire:model="email"
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] focus:z-10 sm:text-sm"
                            placeholder="Email address">
                        @error('email')
                            <span class="text-red-500 text-sm italic">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" type="password" wire:model="password"
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] focus:z-10 sm:text-sm"
                            placeholder="Password">
                        @error('password')
                            <span class="text-red-500 text-sm italic">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember_me" type="checkbox" wire:model="remember"
                            class="h-4 w-4 text-[#33CD99] focus:ring-[#33CD99] border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                            Remember me
                        </label>
                    </div>

                    <div class="text-sm leading-5">
                        <a href="{{ route('password.request') }}" class="font-medium text-[#33CD99] hover:text-green-600 focus:outline-none focus:underline transition ease-in-out duration-150">
                            Forgot your password?
                        </a>
                    </div>
                </div>

                <div class="space-y-3 flex flex-col items-center">
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white hover:to-[#33cd6e] to-[#33CD99] bg-gradient-to-r from-[#33cd6e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#33CD99]">
                        Sign in
                    </button>
                    <a class="text-[#33CD99] hover:underline text-sm" href="/register">New to Jasafy?</a>
                </div>
            </form>
        </div>
    </div>

    <div class="h-full">
        {{-- <div class="h-full w-full block bg-black/50 absolute inset-0 m-auto z-10" /> --}}
        <img class="h-full object-cover"
            src="https://images.unsplash.com/photo-1629904853716-f0bc54eea481?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            alt="login">
    </div>
</div>