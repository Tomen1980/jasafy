@section('title', 'Edit your profile')

<div x-data="{ open: false, imageUrl: '' }">
    <div class="flex items-center md:h-[calc(100vh-5rem)]">
        <div class="container mx-auto p-4">
            <div class="mx-auto bg-white p-6 rounded-lg w-full border">
                <h2 class="text-2xl font-semibold mb-4">Edit Profile</h2>
                @if (session()->has('message'))
                    <div class="bg-green-500 text-white p-2 rounded mb-4">
                        {{ session('message') }}
                    </div>
                @endif

                @auth
                    <form class="grid grid-cols-1 md:grid-cols-2 gap-10" wire:submit.prevent="updateProfile"
                        enctype="multipart/form-data">
                        <div>
                            <div class="mb-4">
                                <label for="new_image" class="block text-sm font-medium text-gray-700">Profile Image</label>
                                <input accept="image/jpeg, image/jpg, image/png, image/webp" type="file" id="new_image"
                                    wire:model="new_image"
                                    class="mt-1 appearance-none block w-full border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] shadow-sm p-2">
                                @error('new_image')
                                    <span class="text-red-500 text-sm italic">{{ $message }}</span>
                                @enderror
                                @if ($new_image)
                                    <img src="{{ $new_image->temporaryUrl() }}" class="mt-2 h-20 w-20 rounded-full cursor-pointer" @click="open = true; imageUrl = '{{ $new_image->temporaryUrl() }}'">
                                @elseif($image)
                                    <img src="{{ $image === 'default.jpg' ? Storage::url('profiles/default.jpg') : Storage::url($image) }}"
                                        class="mt-2 h-20 w-20 object-cover rounded-full cursor-pointer" alt="{{ $name }}" @click="open = true; imageUrl = '{{ $image === 'default.jpg' ? Storage::url('profiles/default.jpg') : Storage::url($image) }}'">
                                @endif
                            </div>

                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" id="name" wire:model="name"
                                    class="mt-1 appearance-none block w-full border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] shadow-sm p-2">
                                @error('name')
                                    <span class="text-red-500 text-sm italic">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                                <input type="text" id="username" wire:model="username"
                                    class="mt-1 appearance-none block w-full border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] shadow-sm p-2">
                                @error('username')
                                    <span class="text-red-500 text-sm italic">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea id="description" wire:model="description"
                                    class="mt-1 appearance-none block w-full border min-h-20 max-h-40 border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] shadow-sm p-2"></textarea>
                                @error('description')
                                    <span class="text-red-500 text-sm italic">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" wire:model="email"
                                    class="mt-1 appearance-none block w-full border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] shadow-sm p-2">
                                @error('email')
                                    <span class="text-red-500 text-sm italic">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input type="text" id="phone_number" wire:model="phone_number"
                                    class="mt-1 appearance-none block w-full border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] shadow-sm p-2">
                                @error('phone_number')
                                    <span class="text-red-500 text-sm italic">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="mb-4">
                                <label for="current_password" class="block text-sm font-medium text-gray-700">Old Password</label>
                                <input type="password" id="current_password" wire:model="current_password"
                                    class="mt-1 appearance-none block w-full border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] shadow-sm p-2">
                                @error('current_password')
                                    <span class="text-red-500 text-sm italic">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                                <input type="password" id="new_password" wire:model="new_password"
                                    class="mt-1 appearance-none block w-full border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] shadow-sm p-2">
                                @error('new_password')
                                    <span class="text-red-500 text-sm italic">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="passwordConfirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                <input type="password" id="passwordConfirmation" wire:model="passwordConfirmation"
                                    class="mt-1 appearance-none block w-full border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] shadow-sm p-2">
                                @error('passwordConfirmation')
                                    <span class="text-red-500 text-sm italic">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit"
                            class="rounded hover:from-[#33CD99] to-[#33CD99] bg-gradient-to-r hover:to-[#33cd6e] from-[#33cd6e] text-white px-10 py-2 w-full text-center">Update Profile</button>
                    </form>
                @endauth
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div x-show="open" @keydown.escape.window="open = false">
        <div x-cloak
            class="fixed inset-0 bg-gray-500/50 z-[99] overflow-y-auto h-screen flex justify-center items-center"
            @click.self="open = false">
            <div
                class="bg-white rounded-lg shadow-lg p-4 w-full max-w-2xl max-h-[70vh] flex justify-center items-center relative">
                <button @click="open = false" class="text-gray-400 hover:text-gray-500 absolute top-0 right-0 m-4">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
                <img :src="imageUrl" alt="profile preview" class="max-h-[70vh] object-contain">
            </div>
        </div>
</div>
