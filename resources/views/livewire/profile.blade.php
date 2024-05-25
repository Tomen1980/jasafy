@section('title', 'Edit your profile')

<div class="flex items-center md:h-[calc(100vh-5rem)]">
    <div class="container mx-auto p-4">
        <div class="mx-auto bg-white p-6 rounded-lg w-full shadow-md">
            <h2 class="text-2xl font-semibold mb-4">Edit Profile</h2>
            @if (session()->has('message'))
                <div class="bg-green-500 text-white p-2 rounded mb-4">
                    {{ session('message') }}
                </div>
            @endif

            @auth
                <form class="grid grid-cols-1 md:grid-cols-2 gap-10" wire:submit.prevent="updateProfile" enctype="multipart/form-data">
                    <div>
                        <div class="mb-4">
                            <label for="new_image" class="block text-sm font-medium text-gray-700">Profile Image</label>
                            <input type="file" id="new_image" wire:model="new_image"
                                class="mt-1 appearance-none block w-full border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] shadow-sm p-2">
                            @error('new_image')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                            @if ($new_image)
                                <img src="{{ $new_image->temporaryUrl() }}" class="mt-2 h-20 w-20 rounded-full">
                            @elseif($image)
                                <img src="{{$image == "default.jpg" ? Storage::url('profile/default.jpg') :Storage::url($image) }}" class="mt-2 h-20 w-20 rounded-full"
                                    alt={{ $name }}>
                            @endif
                        </div>
    
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" id="name" wire:model="name"
                                class="mt-1 appearance-none block w-full border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] shadow-sm p-2">
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
    
                        <div class="mb-4">
                            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                            <input type="text" id="username" wire:model="username"
                                class="mt-1 appearance-none block w-full border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] shadow-sm p-2">
                            @error('username')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
    
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="description" wire:model="description"
                                class="mt-1 appearance-none block w-full border min-h-20 max-h-40 border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] shadow-sm p-2"></textarea>
                            @error('description')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" wire:model="email"
                                class="mt-1 appearance-none block w-full border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] shadow-sm p-2">
                            @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
    
                        <div class="mb-4">
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" id="phone_number" wire:model="phone_number"
                                class="mt-1 appearance-none block w-full border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] shadow-sm p-2">
                            @error('phone_number')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
    
    
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" id="password" wire:model="password"
                                class="mt-1 appearance-none block w-full border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] shadow-sm p-2">
                            @error('password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
    
                        <div class="mb-4">
                            <label for="passwordConfirmation" class="block text-sm font-medium text-gray-700">Confirm
                                Password</label>
                            <input type="password" id="passwordConfirmation" wire:model="passwordConfirmation"
                                class="mt-1 appearance-none block w-full border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] shadow-sm p-2">
                            @error('passwordConfirmation')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="rounded hover:from-[#33CD99] to-[#33CD99] bg-gradient-to-r hover:to-[#33cd6e] from-[#33cd6e] text-white px-10 py-2 w-full text-center">Update
                        Profile</button>
                </form>
            @endauth
        </div>
    </div>
</div>
