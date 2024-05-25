@section('title', 'Jasa - ' . $service->title)

<div class="h-[calc(100vh-5rem)] w-full" x-data="serviceDetail({{ json_encode(['price' => $service->price, 'ratings' => $service->ratings]) }})">
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
                <button
                    class="font-medium rounded-md text-white py-3 px-9 hover:to-[#33cd6e] to-[#33CD99] bg-gradient-to-r from-[#33cd6e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#33CD99]">Order
                    now</button>
                <button
                    class="font-medium rounded-md py-3 px-9 bg-gray-200 hover:bg-gray-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#33CD99]">Chat</button>
            </div>
        </div>
        <img src="{{ $service->image == "defaultService.jpg" ? Storage::url('public/services/') . $service->image :  Storage::url($service->image)}}" alt="{{ $service->title }}"
            class="mb-4 w-full lg:w-[36rem] xl:w-[44rem] object-cover h-96 lg:h-[32rem] lg:ml-auto rounded">
    </div>
    {{-- <h3 class="text-xl font-bold mb-2">Ratings</h3>
        <ul class="list-disc pl-5">
            @foreach ($service->ratings as $rating)
                <li>{{ $rating->rating }}: {{ $rating->comment }}</li>
            @endforeach
        </ul> --}}
</div>

<script>
    function serviceDetail(data) {
        return {
            ratings: data.ratings,
            price: data.price,
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
