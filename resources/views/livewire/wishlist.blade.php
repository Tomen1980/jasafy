@section('title', 'My wishlist')

<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Your Wishlist <span class="text-green-500">({{ $wishlist->count() }})</span></h2>

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
        @forelse($wishlist as $w)
            <div class="p-4 bg-white border overflow-hidden sm:rounded-lg space-y-3 group" wire:key={{ $w->id }}>
                <div class="h-44 relative w-full">
                    <img src="{{ $w->service->image === 'defaultService.jpg' ? Storage::url('services/') . $w->service->image : Storage::url($w->service->image) }}"
                        alt="{{ $w->service->title }}" class="w-full h-full object-cover rounded-md">
                    <div
                        class="bg-black/50 absolute hidden inset-0 m-auto rounded-md group-hover:flex items-center justify-center">
                        <a class="bg-yellow-500 text-white px-4 py-2 rounded transition border-transparent hover:bg-transparent border hover:border-yellow-500 hover:text-yellow-500"
                            wire:navigate href={{ route('service.detail', $w->service->id) }}>Details</a>
                    </div>
                </div>
                <p>{{ $w->service->title }}</p>
                <p>{{ $w->service->price }}</p>
                <div class="flex flex-col md:flex-row items-center md:space-x-3 md:space-y-0 space-y-3">
                <button class="px-4 py-2 bg-green-500 text-white rounded w-full md:w-fit" wire:click="placeOrder({{ $w->service->id }})">Order</button>
                    <button wire:click="removeFromWishlist({{ $w->id }})"
                        class="px-4 py-2 bg-red-500 text-white rounded w-full md:w-fit">Remove</button>
                </div>
            </div>
        @empty
            <p>No wishlist items yet...</p>
        @endforelse
    </div>
</div>