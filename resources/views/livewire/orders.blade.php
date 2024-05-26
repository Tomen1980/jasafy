@section('title', 'Incoming orders')

<div class="container mx-auto p-4" x-data="{ showModal: false, receiptUrl: '', showConfirm: false, orderId: null, status: '' }">
    <h2 class="text-2xl font-bold mb-4">Incoming Orders <span class="text-green-500">({{ $orders->count() }})</span></h2>

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

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
        @forelse($orders as $order)
            <div class="p-4 bg-white border overflow-hidden sm:rounded-lg space-y-3 group h-96" wire:key={{ $order->id }}>
                <div class="h-44 relative w-full mb-4">
                    <img src="{{ $order->service->image === 'defaultService.jpg' ? Storage::url('services/') . $order->service->image : Storage::url($order->service->image) }}"
                        alt="{{ $order->service->title }}" class="w-full h-full object-cover rounded-md">
                    <div
                        class="bg-black/50 absolute hidden inset-0 m-auto rounded-md group-hover:flex items-center justify-center">
                        <a class="bg-yellow-500 text-white px-4 py-2 rounded transition border-transparent hover:bg-transparent border hover:border-yellow-500 hover:text-yellow-500"
                            wire:navigate href={{ route('service.detail', $order->service->id) }}>Details</a>
                    </div>
                </div>
                <span
                    :class="{
                        'bg-yellow-500': '{{ $order->status }}'
                        === 'Pending',
                        'bg-blue-500': '{{ $order->status }}'
                        === 'On Going',
                        'bg-green-500': '{{ $order->status }}'
                        === 'Completed',
                        'bg-red-500': '{{ $order->status }}'
                        === 'Cancelled',
                    }"
                    class="text-sm px-4 py-2 rounded-md text-white">{{ $order->status }}</span>
                <p>{{ $order->service->title }}</p>
                <p>{{ $order->service->price }}</p>
                <div class="flex flex-col md:flex-row items-center md:space-x-3 md:space-y-0 space-y-3">
                    <button @click="receiptUrl = '{{ Storage::url('') . $order->file_url }}'; showModal = true"
                        class="px-4 py-2 text-blue-500 bg-transparent hover:bg-blue-500 hover:text-white rounded w-full md:w-fit border border-blue-500">See
                        receipt</button>
                    @if ($order->status !== 'Completed')
                        <button
                            @click="orderId = '{{ $order->id }}'; showConfirm = true; status = '{{ $order->status }}'"
                            class="px-4 py-2 bg-green-500 text-white rounded w-full md:w-fit">{{ $order->status === 'Pending' ? 'Accept' : 'Complete' }}</button>
                    @endif
                </div>
            </div>
        @empty
            <p>No order items yet...</p>
        @endforelse
    </div>

    <!-- Modal -->
    <div x-show="showModal" class="fixed inset-0 flex items-center justify-center z-50" @keydown.escape.window="showModal = false">
        <div class="fixed inset-0 bg-gray-800 opacity-50" @click="showModal = false"></div>
        <div
            class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full max-h-[70vh] p-4">
            <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Receipt</h3>
                <button @click="showModal = false" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="mt-4 overflow-auto">
                <img :src="receiptUrl" class="w-full h-full">
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div x-show="showConfirm" class="fixed inset-0 flex items-center justify-center z-50" @keydown.escape.window="showConfirm = false">
        <div class="fixed inset-0 bg-gray-800 opacity-50" @click="showConfirm = false"></div>
        <div
            class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full max-h-[70vh] p-4">
            <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900" x-text="status === 'Pending' ? 'Confirm Order' : status === 'On Going' ? 'Complete Order' : ''"></h3>
                <button @click="showConfirm = false" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="mt-4">
                <p x-text="status === 'Pending' ? 'Are you sure you want to accept this order?' : status === 'On Going' ? 'Are you sure you want to complete this order?' : ''">Are you sure you want to accept this order?</p>
                <div class="flex justify-end mt-4">
                    <button @click="showConfirm = false"
                        class="px-4 py-2 bg-gray-500 text-white rounded mr-2">Cancel</button>
                    <button @click="$wire.proceedStatus(orderId, status); showConfirm = false"
                        class="px-4 py-2 bg-green-500 text-white rounded" x-text="status === 'Pending' ? 'Yes, accept' : 'Yes, complete'"></button>
                </div>
            </div>
        </div>
    </div>
</div>
