@section('title', $service->title)

<div class="h-[calc(100vh-5rem)] w-full" x-data="serviceDetail({{ json_encode(['price' => $service->price, 'ratings' => $service->ratings, 'image' => $service->image === 'defaultService.jpg' ? Storage::url('services/defaultService.jpg') : Storage::url($service->image)]) }})">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 flex lg:items-center flex-col-reverse lg:flex-row w-full py-12">
        <div>
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
                    <a class="font-medium rounded-md py-3 px-9 bg-gray-200 hover:bg-gray-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#33CD99]"
                        target="_blank" rel="noopener noreferrer"
                        href={{ 'https://wa.me/' . $service->user->phone_number }}>Chat</a>
                @else
                    <button @click="showEditModal = true"
                        class="font-medium rounded-md text-white py-3 px-9 hover:to-[#33cd6e] to-[#33CD99] bg-gradient-to-r from-[#33cd6e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#33CD99]">
                        Edit Service
                    </button>
                @endif
            </div>
        </div>
        <img src="{{ $service->image == 'defaultService.jpg' ? Storage::url('public/services/') . $service->image : Storage::url($service->image) }}"
            alt="{{ $service->title }}"
            class="mb-4 w-full lg:w-[36rem] p-2 border xl:w-[44rem] object-cover h-96 lg:h-[32rem] lg:ml-auto rounded-md cursor-pointer"
            @click="showPreviewModal = true">
    </div>

    <div x-show="showEditModal" @keydown.escape.window="showEditModal = false" @click.self="showEditModal = false">
        <div x-cloak
            class="fixed inset-0 bg-gray-500/50 z-[99] overflow-y-auto h-screen flex justify-center items-center">
            <div class="bg-white rounded-lg shadow-lg p-4 w-full max-w-2xl">
                <h3 class="text-xl font-bold mb-4">Edit Service</h3>
                <form @submit.prevent="handleSubmit">
                    <div class="mb-3">
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-700">Title</label>
                        <input type="text" id="title"
                            class="block w-full rounded-md border border-gray-300 py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            v-model="service.title">
                    </div>
                    <div class="mb-3">
                        <label for="description"
                            class="block mb-2 text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description"
                            class="block w-full rounded-md border border-gray-300 py-2 px-3 focus:outline-none focus:ring-indigo-500 min-h-20 max-h-40 focus:border-indigo-500"
                            v-model="service.description"></textarea>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="button"
                            class="rounded-md border border-gray-300 py-2 px-4 text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            @click="showEditModal = false">Cancel</button>
                        <button type="submit"
                            class="ml-3 inline-flex items-center px-4 py-2 bg-indigo-500 rounded-md font-medium text-white hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div x-show="showPreviewModal" @keydown.escape.window="showPreviewModal = false">
        <div x-cloak
            class="fixed inset-0 bg-gray-500/50 z-[99] overflow-y-auto h-screen flex justify-center items-center"
            @click.self="showPreviewModal = false">
            <div
                class="bg-white rounded-lg shadow-lg p-4 w-full max-w-2xl max-h-[70vh] flex justify-center items-center relative">
                <button @click="showPreviewModal = false" class="text-gray-400 hover:text-gray-500 absolute top-0 right-0 m-4">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
                <img :src="imageSrc" alt="{{ $service->title }}" class="max-h-[70vh] object-contain">
            </div>
        </div>
    </div>
</div>

<script>
    function serviceDetail(data) {
        return {
            showEditModal: false,
            showPreviewModal: false,
            ratings: data.ratings,
            price: data.price,
            imageSrc: data.image,
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
