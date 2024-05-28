@section('title', $service->title)

<div class="h-[calc(100vh-5rem)] w-full" x-data="{
    ...serviceDetail({{ json_encode(['price' => $service->price, 'ratings' => $service->ratings]) }}),
    showEditModal: $wire.entangle('isModalOpen').live,
    showPreviewModal: false,
    serviceId: null
}">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 flex lg:items-center flex-col-reverse lg:flex-row w-full py-12">
        <div>
            @if (session()->has('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative container mx-auto mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative container mx-auto mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            <p class="text-[#9F4A22] mb-2 uppercase">Jasafy Product</p>
            <h1 class="md:text-4xl text-2xl font-bold mb-4 truncate max-w-lg">{{ $service->title }}</h1>
            <p class="text-gray-600 mb-4 text-lg md:text-2xl truncate max-w-lg">{{ $service->description }}</p>
            <p class="text-gray-600 mb-2 text-lg md:text-2xl truncate max-w-lg">{{ '@' . $service->user->username }}</p>
            <div class="inline-flex gap-3">
                <svg class="h-8 w-8 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                </svg>
                <p class="text-gray-600 text-lg md:text-2xl" x-text="averageRating"></p>
            </div>
            <p class="text-gray-600 mb-4 truncate max-w-lg text-lg md:text-2xl">{{ $service->location }}</p>
            <p class="text-gray-600 mb-8 md:text-xl" x-text="formattedPrice"></p>

            <div class="lg:space-x-3 space-y-3 lg:space-y-0 flex flex-col lg:flex-row w-full lg:w-fit lg:items-center">
                @if (Auth::user()->role !== 'seller' && Auth::user()->id !== $service->user_id)
                    <button
                        class="font-medium rounded-md text-white py-3 px-9 hover:to-[#33cd6e] to-[#33CD99] bg-gradient-to-r from-[#33cd6e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#33CD99]"
                        wire:click="placeOrder({{ $service->id }})">Order
                        now</button>
                    <a class="font-medium rounded-md py-3 px-9 bg-gray-200 hover:bg-gray-500 hover:text-white text-center focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#33CD99]"
                        target="_blank" rel="noopener noreferrer"
                        href={{ 'https://wa.me/' . $service->user->phone_number }}>Chat</a>
                @else
                    <button @click="showEditModal = true; $wire.edit({{ $service->id }});"
                        class="font-medium rounded-md text-white py-3 px-9 hover:to-[#33cd6e] to-[#33CD99] bg-gradient-to-r from-[#33cd6e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#33CD99]">
                        Edit Service
                    </button>
                @endif
            </div>
        </div>
        <img src="{{ $service->image === 'defaultService.jpg' ? Storage::url('public/services/') . $service->image : Storage::url($service->image) }}"
            alt="{{ $service->title }}"
            class="mb-4 w-full lg:w-[36rem] p-2 border xl:w-[44rem] object-cover h-96 lg:h-[32rem] lg:ml-auto rounded-md cursor-pointer"
            @click="showPreviewModal = true">
    </div>

    <!-- Ratings Section -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h2 class="text-2xl font-bold mb-6">Ratings</h2>
        <div class="space-y-6">
            @forelse($service->ratings as $rating)
                <div class="flex items-start space-x-4">
                    <img class="h-12 w-12 rounded-full object-cover shrink-0"
                        src={{ Storage::url('profiles/') . $rating->user->image }}
                        alt="{{ $rating->user->username }}">
                    <div>
                        <div class="flex items-center space-x-2">
                            <h3 class="text-lg font-semibold">{{ $rating->user->username }}</h3>
                            <span class="text-gray-500 text-sm">{{ $rating->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center mt-1">
                            @for ($i = 0; $i < $rating->rating; $i++)
                                <svg class="h-5 w-5 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            @endfor
                        </div>
                        <p class="text-gray-600 mt-2 max-h-40 overflow-y-auto">{{ $rating->comment }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-600">No ratings yet for this service...</p>
            @endforelse
        </div>
    </div>

    @if (Auth::user()->role === 'seller' && Auth::user()->id === $service->user_id)
        <div x-show="showEditModal" @keydown.escape.window="showEditModal = false">
            <div x-cloak
                class="fixed inset-0 bg-gray-500/50 z-[99] overflow-y-auto h-screen flex justify-center items-center"
                @click.self="showEditModal = false">
                <div class="bg-white rounded-lg shadow-lg p-4 w-full max-w-2xl">
                    <h3 class="text-xl font-bold mb-4">Edit Service</h3>
                    <form wire:submit.prevent="update" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Title</label>
                                <input type="text" name="title" id="title" wire:model="title"
                                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] focus:z-10">
                                @error('title')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Description</label>
                                <textarea wire:model="description"
                                    class="appearance-none relative max-h-40 min-h-20 block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] focus:z-10"
                                    name="description" id="description"></textarea>
                                @error('description')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Categories</label>
                                <select wire:model.live="categoryId" name="categoryId" id="categoryId"
                                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] focus:z-10 select2">
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @error('categoryId')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Location</label>
                                <input type="text" wire:model="location"
                                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] focus:z-10"
                                    name="location" id="location">
                                @error('location')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Maps</label>
                                <input type="text" wire:model="maps"
                                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] focus:z-10"
                                    name="maps" id="maps">
                                @error('maps')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Price</label>
                                <input type="number" wire:model="price"
                                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] focus:z-10"
                                    name="price" id="price">
                                @error('price')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <div class="flex items-center gap-2">
                                    <label class="block text-gray-700">Image</label>
                                    @if ($service->image)
                                        <p class="text-sm truncate text-gray-600">{{ $service->image }}</p>
                                    @endif
                                </div>
                                <input type="file" accept="image/png, image/jpg, image/jpeg, image/webp"
                                    wire:model="image"
                                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] focus:z-10"
                                    name="image" id="image">
                                @error('image')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex justify-end">
                                <button @click="showEditModal = false;"
                                    class="bg-gray-500 text-white px-4 py-2 rounded mr-2"
                                    type="button">Cancel</button>
                                <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif


    <!-- Preview Modal -->
    <div x-show="showPreviewModal" @keydown.escape.window="showPreviewModal = false">
        <div x-cloak
            class="fixed inset-0 bg-gray-500/50 z-[99] overflow-y-auto h-screen flex justify-center items-center"
            @click.self="showPreviewModal = false">
            <div
                class="bg-white rounded-lg shadow-lg p-4 w-full max-w-2xl max-h-[70vh] flex justify-center items-center relative">
                <button @click="showPreviewModal = false"
                    class="text-gray-400 hover:text-gray-500 absolute top-0 right-0 m-4">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
                <img src="{{ $service->image === 'defaultService.jpg' ? Storage::url('public/services/') . $service->image : Storage::url($service->image) }}"
                    alt="{{ $service->title }}" class="max-h-[70vh] object-contain">
            </div>
        </div>
    </div>
</div>

<script>
    function serviceDetail(data) {
        return {
            ratings: data.ratings,
            price: data.price,
            showEditModal: false,
            showPreviewModal: false,
            get formattedPrice() {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(this.price);
            },
            get averageRating() {
                if (this.ratings.length > 0) {
                    let total = this.ratings.reduce((sum, rating) => sum + rating.rating, 0);
                    return (total / this.ratings.length).toFixed(1);
                }
                return 0;
            },
        };
    }
</script>
