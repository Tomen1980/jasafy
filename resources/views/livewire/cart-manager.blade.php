@section('title', 'Cart')

<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Your Cart</h2>

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

    <ul class="divide-y divide-gray-200">
        @forelse($carts as $cart)
            <li class="p-4 flex items-center justify-between bg-white shadow overflow-hidden sm:rounded-lg">
                <div>
                    {{ $cart->service->title }}
                </div>
                <button wire:click="removeFromCart({{ $cart->id }})"
                    class="p-2 bg-red-500 text-white rounded">Remove</button>
            </li>
        @empty
            <p>No cart items yet...</p>
        @endforelse
    </ul>
</div>
