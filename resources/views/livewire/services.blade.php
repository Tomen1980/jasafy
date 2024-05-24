@section('title', 'Services')

<div x-data="{ openModal: false, isEditing: false, confirmingDeletion: false, serviceId: null }">
    <div class="h-96 w-full to-[#33CD99] bg-gradient-to-r from-[#33cd6e] relative shadow">
        <div
            class="container mx-auto px-4 h-full flex lg:items-center justify-center lg:justify-start flex-col-reverse lg:flex-row gap-5">
            <div class="space-y-6 z-30 lg:z-[initial]">
                <h1 class="font-bold text-2xl md:text-4xl text-white">Jasafy</h1>
                <h5 class="text-white md:text-lg italic">Where skills meet opportunity</h5>
                <p
                    class="text-white lg:max-w-lg text-sm lg:text-base text-justify overflow-y-auto max-h-36 lg:max-h-[initial]">
                    Jelajahi berbagai kategori layanan kami dan temukan penyedia jasa
                    terampil yang siap memenuhi setiap tuntutan Anda. Dari layanan teknis hingga kreatif, kami telah
                    menyusun pilihan jasa yang beragam untuk memastikan kebutuhan unik Anda dapat terpenuhi dengan
                    mudah.
                    Mari temukan kemudahan dalam mendapatkan layanan berkualitas dan berdayakan proyek Anda dengan
                    profesional handal yang telah terverifikasi di platform kami.</p>
            </div>

            <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="service" class="lg:h-80 lg:w-[32rem] object-cover rounded lg:ml-auto hidden lg:block shadow">
        </div>
        <span class="lg:hidden w-full h-full absolute inset-0 m-auto bg-black/50 z-20 lg:z-[initial]"></span>

        <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            alt="service" class="lg:hidden object-cover w-full h-full absolute inset-0 m-auto">
    </div>

    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Services</h1>
            @if (Auth::user()->role === 'seller')
                <button class="bg-blue-500 text-white px-4 py-2 rounded"
                    @click="openModal = true; isEditing = false; $wire.resetInputFields()">Add Service</button>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            @foreach ($services as $service)
                <div class="bg-white p-4 rounded-lg border" wire:key={{ $service->id }}>
                    <div class="h-44 relative w-full group">
                        <img src="{{ $service->image ? Storage::url('service/') . $service->image : 'https://via.placeholder.com/150' }}"
                            alt="{{ $service->title }}" class="w-full h-full object-cover rounded-md">
                        <div
                            class="bg-black/50 absolute hidden inset-0 m-auto rounded-md group-hover:flex items-center justify-center">
                            <a class="bg-yellow-500 text-white px-4 py-2 rounded transition border-transparent hover:bg-transparent border hover:border-yellow-500 hover:text-yellow-500"
                                wire:navigate href={{ route('service.detail', $service->id) }}>Details</a>
                        </div>
                    </div>
                    <h2 class="text-xl font-bold mt-4">{{ $service->title }}</h2>
                    <p class="text-gray-600">{{ '@' . $service->user->username }}</p>
                    <p class="text-gray-600">{{ $service->description }}</p>
                    <p class="text-gray-600">{{ $service->location }}</p>
                    <div class="flex items-center mt-4 space-x-3">
                        <a class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-md transition ease-out"
                            href={{ $service->maps }} target="_blank" rel="noopener noreferrer">Google
                            Maps</a>
                        @if (Auth::user()->role === 'customer')
                            <button
                                class="px-4 py-2 bg-lime-500 rounded hover:bg-lime-700 text-white ease-out transition"
                                wire:click="addToCart({{ $service->id }})">Add to cart</button>
                        @endif
                        @if (Auth::user()->role === 'seller' && Auth::user()->id === $service->user_id)
                            <button class="bg-green-500 text-white px-4 py-2 rounded"
                                @click="openModal = true; isEditing = true; $wire.edit({{ $service->id }})">Edit</button>
                            <button class="bg-red-500 text-white px-4 py-2 rounded"
                                @click="confirmingDeletion = true; serviceId = {{ $service->id }}">Delete</button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div x-show="openModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
                <h2 class="text-2xl font-bold mb-4" x-text="isEditing ? 'Edit Service' : 'Add Service'"></h2>
                <form wire:submit.prevent="store">
                    <div class="mb-4">
                        <label class="block text-gray-700">Title</label>
                        <input type="text" wire:model="title" class="w-full p-2 border rounded">
                        @error('title')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Description</label>
                        <textarea wire:model="description" class="w-full p-2 border rounded"></textarea>
                        @error('description')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Location</label>
                        <input type="text" wire:model="location" class="w-full p-2 border rounded">
                        @error('location')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Maps</label>
                        <input type="text" wire:model="maps" class="w-full p-2 border rounded">
                        @error('maps')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Price</label>
                        <input type="number" wire:model="price" class="w-full p-2 border rounded">
                        @error('price')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Image</label>
                        <input type="file" wire:model="image" class="w-full p-2 border rounded">
                        @error('image')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex justify-end">
                        <button @click="openModal = false"
                            class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded" x-text="isEditing ? 'Update' : 'Add'"></button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div x-show="confirmingDeletion"
            class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center z-[99]">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                <h2 class="text-2xl font-bold mb-4">Confirm Deletion</h2>
                <p>Are you sure you want to delete this service?</p>
                <div class="flex justify-end mt-4">
                    <button @click="confirmingDeletion = false"=false"
                        class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
                    <button class="bg-red-500 text-white px-4 py-2 rounded"
                        @click="$wire.deleteService(serviceId); showDeleteModal = false;">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
