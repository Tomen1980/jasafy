@section('title', 'My orders')

<div class="container mx-auto p-4" x-data="{ 
    showModal: false, 
    receiptUrl: '', 
    showRatingModal: false, 
    showUpdateModal: false, 
    showConfirmDeleteModal: false,
    ratingData: { rating: null, comment: null, orderId: null, serviceId: null, ratingId: null },
    deleteRatingId: null
}">
    <h2 class="text-2xl font-bold mb-4">Your Orders <span class="text-green-500">({{ $orders->count() }})</span></h2>

    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
        @forelse($orders as $order)
            <div class="p-4 bg-white border overflow-hidden sm:rounded-lg space-y-3 group md:h-96" wire:key="{{ $order->id }}">
                <div class="h-44 relative w-full mb-4">
                    <img src="{{ $order->service->image === 'defaultService.jpg' ? Storage::url('services/') . $order->service->image : Storage::url($order->service->image) }}"
                        alt="{{ $order->service->title }}" class="w-full h-full object-cover rounded-md">
                    <div class="bg-black/50 absolute hidden inset-0 m-auto rounded-md group-hover:flex items-center justify-center">
                        <a class="bg-yellow-500 text-white px-4 py-2 rounded transition border-transparent hover:bg-transparent border hover:border-yellow-500 hover:text-yellow-500"
                            href="{{ route('service.detail', $order->service->id) }}">Details</a>
                    </div>
                </div>
                <span :class="{
                        'bg-yellow-500': '{{ $order->status }}' === 'Pending',
                        'bg-blue-500': '{{ $order->status }}' === 'On Going',
                        'bg-green-500': '{{ $order->status }}' === 'Completed',
                        'bg-red-500': '{{ $order->status }}' === 'Cancelled',
                    }"
                    class="text-sm px-4 py-2 rounded-md text-white">{{ $order->status }}</span>
                <p>{{ $order->service->title }}</p>
                <p>{{ $order->service->price }}</p>
                <div class="flex flex-col md:flex-row items-center md:space-x-3 md:space-y-0 space-y-3 overflow-x-auto">
                    <button @click="receiptUrl = '{{ Storage::url('') . $order->file_url }}'; showModal = true"
                        class="px-4 py-2 text-blue-500 bg-transparent hover:bg-blue-500 hover:text-white rounded w-full md:w-fit border border-blue-500 whitespace-nowrap">See
                        receipt</button>
                    @if ($order->status === "Completed")
                        @if ($order->rating)
                            <button @click="
                                ratingData = {
                                    orderId: {{ $order->id }},
                                    serviceId: {{ $order->service->id }},
                                    ratingId: {{ $order->rating->id }},
                                    rating: {{ $order->rating->rating }},
                                    comment: '{{ $order->rating->comment }}'
                                }; 
                                showUpdateModal = true"
                                class="px-4 py-2 bg-yellow-500 text-white rounded w-full md:w-fit whitespace-nowrap">Update Rating</button>
                            <button @click="deleteRatingId = {{ $order->rating->id }}; showConfirmDeleteModal = true"
                                class="px-4 py-2 bg-red-500 text-white rounded w-full md:w-fit whitespace-nowrap">Delete Rating</button>
                        @else
                            <button @click="
                                ratingData = {
                                    orderId: {{ $order->id }},
                                    serviceId: {{ $order->service->id }}
                                }; 
                                showRatingModal = true"
                                class="px-4 py-2 bg-orange-500 text-white rounded w-full md:w-fit whitespace-nowrap">Rate</button>
                        @endif
                    @endif
                </div>
            </div>
        @empty
            <p>No order items yet...</p>
        @endforelse
    </div>

    <!-- Receipt Modal -->
    <div x-show="showModal" class="fixed inset-0 flex items-center justify-center z-[99]" @keydown.escape.window="showModal = false">
        <div class="fixed inset-0 bg-gray-800 opacity-50" @click="showModal = false"></div>
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg w-full max-h-[70vh] p-4">
            <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Receipt</h3>
                <button @click="showModal = false" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="mt-4 overflow-auto">
                <img :src="receiptUrl" class="w-full h-full object-contain">
            </div>
        </div>
    </div>

    <!-- Rating Modal -->
    <div x-show="showRatingModal" class="fixed inset-0 flex items-center justify-center z-[99]" @keydown.escape.window="showRatingModal = false">
        <div class="fixed inset-0 bg-gray-800 opacity-50" @click="showRatingModal = false"></div>
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg w-full max-h-[70vh] p-4">
            <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Rate Service</h3>
                <button @click="showRatingModal = false" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="mt-4">
                <label class="block text-gray-700">Rating:</label>
                <input type="number" min="1" max="5" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] focus:z-10" x-model="ratingData.rating">
            </div>
            <div class="mt-4">
                <label class="block text-gray-700">Comment:</label>
                <textarea class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] focus:z-10 min-h-20 max-h-40" x-model="ratingData.comment"></textarea>
            </div>
            <div class="mt-4 flex justify-end">
                <button @click="$wire.set('serviceId', ratingData.serviceId); $wire.set('rating', ratingData.rating); $wire.set('comment', ratingData.comment); $wire.rateService(); showRatingModal = false"
                    class="px-4 py-2 bg-green-500 text-white rounded">Submit</button>
            </div>
        </div>
    </div>

    <!-- Update Rating Modal -->
    <div x-show="showUpdateModal" class="fixed inset-0 flex items-center justify-center z-[99]" @keydown.escape.window="showUpdateModal = false">
        <div class="fixed inset-0 bg-gray-800 opacity-50" @click="showUpdateModal = false"></div>
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg w-full max-h-[70vh] p-4">
            <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Update Rating</h3>
                <button @click="showUpdateModal = false" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="mt-4">
                <label class="block text-gray-700">Rating:</label>
                <input type="number" min="1" max="5" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] focus:z-10" x-model="ratingData.rating">
            </div>
            <div class="mt-4">
                <label class="block text-gray-700">Comment:</label>
                <textarea class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-[#33CD99] focus:border-[#33CD99] focus:z-10 min-h-20 max-h-40" x-model="ratingData.comment"></textarea>
            </div>
            <div class="mt-4 flex justify-end">
                <button @click="$wire.set('ratingId', ratingData.ratingId); $wire.set('rating', ratingData.rating); $wire.set('comment', ratingData.comment); $wire.updateRating(); showUpdateModal = false"
                    class="px-4 py-2 bg-yellow-500 text-white rounded">Update</button>
            </div>
        </div>
    </div>

    <!-- Confirm Delete Modal -->
    <div x-show="showConfirmDeleteModal" class="fixed inset-0 flex items-center justify-center z-[99]" @keydown.escape.window="showConfirmDeleteModal = false">
        <div class="fixed inset-0 bg-gray-800 opacity-50" @click="showConfirmDeleteModal = false"></div>
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg w-full p-4">
            <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Confirm Delete</h3>
                <button @click="showConfirmDeleteModal = false" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="mt-4">
                <p>Are you sure you want to delete this rating?</p>
            </div>
            <div class="mt-4 flex justify-end space-x-4">
                <button @click="showConfirmDeleteModal = false"
                    class="px-4 py-2 bg-gray-500 text-white rounded">Cancel</button>
                <button @click="$wire.deleteRating(deleteRatingId); showConfirmDeleteModal = false"
                    class="px-4 py-2 bg-red-500 text-white rounded">Delete</button>
            </div>
        </div>
    </div>
</div>
