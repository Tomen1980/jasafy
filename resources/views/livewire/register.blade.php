@extends('layouts.app')


@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 h-[calc(100vh-5rem)] bg-gray-100">
        <div class="h-full flex flex-col items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8">
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Create a new account</h2>
                @if (session()->has('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif
                <form class="mt-8 space-y-6" wire:submit="register">
                    <div class="rounded-md shadow-sm -space-y-px">
                        <div>
                            <label for="name" class="sr-only">Name</label>
                            <input id="name" name="name" type="text" wire:model="name" required
                                class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] focus:z-10 sm:text-sm"
                                placeholder="Name">
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="username" class="sr-only">Username</label>
                            <input id="username" name="username" type="username" wire:model="username" required
                                class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] focus:z-10 sm:text-sm"
                                placeholder="Username">
                            @error('username')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="email" class="sr-only">Email address</label>
                            <input id="email" name="email" type="email" wire:model="email" required
                                class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] focus:z-10 sm:text-sm"
                                placeholder="Email address">
                            @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="phone_number" class="sr-only">Phone number</label>
                            <input id="phone_number" name="phone_number" type="tel" wire:model="phone_number" required
                                class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] focus:z-10 sm:text-sm"
                                placeholder="Phone number">
                            @error('phone_number')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="password" class="sr-only">Password</label>
                            <input id="password" name="password" type="password" wire:model="password" required
                                class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] focus:z-10 sm:text-sm"
                                placeholder="Password">
                            @error('password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="sr-only">Confirm Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password"
                                wire:model="password_confirmation" required
                                class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] focus:z-10 sm:text-sm"
                                placeholder="Confirm Password">
                            @error('password_confirmation')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-3 flex flex-col items-center">
                        <button type="submit"
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white hover:to-[#33cd6e] to-[#33CD99] bg-gradient-to-r from-[#33cd6e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#33CD99]">
                            Register
                        </button>
                        <a class="text-[#33CD99] hover:underline text-sm" href="/login">Already registered?</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="h-full">
            {{-- <div class="h-full w-full block bg-black/50 absolute inset-0 m-auto z-10" /> --}}
            <img class="h-full object-cover"
                src="https://images.unsplash.com/photo-1595126731003-755959b6baf8?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="login">
        </div>
    </div>
@endsection
