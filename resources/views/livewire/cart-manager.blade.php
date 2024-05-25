@section('title', 'Cart')

<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Your Cart <span class="text-green-500">({{ $carts->count() }})</span></h2>

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
        @forelse($carts as $cart)
            <div class="p-4 bg-white border overflow-hidden sm:rounded-lg space-y-3 group" wire:key={{ $cart->id }}>
                <div class="h-44 relative w-full">
                    <img src="{{ $cart->service->image === 'defaultCart.jpg' ? Storage::url('services/') . $cart->service->image : Storage::url($cart->service->image) }}"
                        alt="{{ $cart->service->title }}" class="w-full h-full object-cover rounded-md">
                    <div
                        class="bg-black/50 absolute hidden inset-0 m-auto rounded-md group-hover:flex items-center justify-center">
                        <a class="bg-yellow-500 text-white px-4 py-2 rounded transition border-transparent hover:bg-transparent border hover:border-yellow-500 hover:text-yellow-500"
                            wire:navigate href={{ route('service.detail', $cart->service->id) }}>Details</a>
                    </div>
                </div>
                <p>{{ $cart->service->title }}</p>
                <div class="flex flex-col md:flex-row items-center md:space-x-3 md:space-y-0 space-y-3">
                    <button class="px-4 py-2 bg-green-500 text-white rounded w-full md:w-fit">Order</button>
                    <button wire:click="removeFromCart({{ $cart->id }})"
                        class="px-4 py-2 bg-red-500 text-white rounded w-full md:w-fit">Remove</button>
                </div>
            </div>
        @empty
            <p>No cart items yet...</p>
        @endforelse
    </div>
</div>
