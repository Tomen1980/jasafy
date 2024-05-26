@section('title', 'Order')

<div x-data="orderDetail({{ json_encode(['price' => $service->price, 'image' => $service->image === 'defaultService.jpg' ? Storage::url('services/defaultService.jpg') : Storage::url($service->image)]) }})" class="container mx-auto p-6">
    <!-- Display Success Message -->
    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-2" role="alert">
            <p class="font-bold">Success</p>
            <p>{{ session('message') }}</p>
        </div>
    @endif
    <div class="bg-white divide-y space-y-1.5 border rounded px-8 pt-6 pb-8 mb-4 max-w-5xl mx-auto">
        <p class="text-gray-700 truncate">Product: <span class="font-semibold text-black">{{ $service->title }}</span></p>

        <img src="{{ $service->image === 'defaultService.jpg' ? Storage::url('services/') . $service->image : Storage::url($service->image) }}"
            alt="{{ $service->title }}" class="w-full h-96 object-cover cursor-pointer" @click="showMainImageModal = true">

        <div>
            <div class="py-4">
                <span class="text-gray-700">Total:</span>
                <span class="font-semibold" x-text="formattedPrice"></span>
            </div>

            <p class="mb-2">Upload payment receipt:</p>

            <form wire:submit.prevent="store">
                <!-- Drag and Drop Image Input -->
                <div x-data="{
                    isDragging: false,
                    handleFiles(event) {
                        $refs.fileInput.files = event.dataTransfer.files;
                        $refs.fileInput.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                }" @drop.prevent="isDragging = false; handleFiles($event)"
                    @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false"
                    @click="$refs.fileInput.click()" :class="{ 'border-green-500': isDragging }"
                    class="mb-4 border-dashed border-2 border-gray-300 p-6 rounded-md flex items-center justify-center cursor-pointer">
                    <input type="file" accept="image/jpg, image/jpeg, image/png, image/webp" wire:model="image"
                        class="hidden" x-ref="fileInput">
                    <div class="text-center" x-show="!$wire.image">
                        <p class="mb-2 text-gray-500">Drag and drop an image here, or click to select one</p>
                        <p class="text-sm text-gray-400">Accepted formats: .jpg, .jpeg, .png, .webp</p>
                    </div>
                    @if ($image)
                        <div class="text-center">
                            <p class="mb-2 text-gray-500">Selected Image: <span
                                    class="font-semibold">{{ $image->getClientOriginalName() }}</span></p>
                        </div>
                    @endif
                </div>
                @error('image')
                    <span class="text-red-500 text-sm italic">{{ $message }}</span>
                @enderror

                <!-- Handle Loading State -->
                <div wire:loading wire:target="image" class="text-yellow-500">Loading image...</div>

                <!-- Preview Image -->
                @if ($image)
                    <div class="mt-4 relative group">
                        <p class="text-gray-700">Image Preview:</p>
                        <img src="{{ $image->temporaryUrl() }}" alt="Preview"
                            class="w-48 h-48 object-cover rounded-md cursor-pointer"
                            @click="showUploadedImageModal = true">
                        <button type="button" @click.prevent="$wire.set('image', null)"
                            class="absolute top-0 right-0 mt-2 mr-2 bg-red-500 text-white rounded-full px-4 py-2">
                            Remove
                        </button>
                    </div>
                @endif

                <div x-show="showUploadedImageModal" @keydown.escape.window="showUploadedImageModal = false"
                    @click.self="showUploadedImageModal = false"
                    class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                    <div class="bg-white p-4 rounded-md relative h-[70vh]">
                        <button type="button" @click="showUploadedImageModal = false"
                            class="absolute top-0 right-0 mt-2 mr-2 text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <img src="{{ $image ? $image->temporaryUrl() : '' }}" alt="Image Preview"
                            class="max-w-full h-full">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-between mt-2">
                    <button
                        class="flex justify-center border border-transparent font-bold py-2 px-4 rounded-md text-white hover:to-[#33cd6e] to-[#33CD99] bg-gradient-to-r from-[#33cd6e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#33CD99]"
                        type="submit">
                        Place Order
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Image Preview Modal -->
    <div x-show="showMainImageModal" @keydown.escape.window="showMainImageModal = false">
        <div x-cloak
            class="fixed inset-0 bg-gray-500/50 z-[99] overflow-y-auto h-screen flex justify-center items-center"
            @click.self="showMainImageModal = false">
            <div
                class="bg-white rounded-lg shadow-lg p-4 w-full max-w-2xl max-h-[70vh] flex justify-center items-center relative">
                <button type="button" @click="showMainImageModal = false"
                    class="absolute top-0 right-0 mt-2 mr-2 text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
                <img :src="mainImageSrc" alt="Main Image Preview" class="max-h-[70vh] object-contain">
            </div>
        </div>
    </div>
</div>
<script>
    function orderDetail(data) {
        return {
            price: data.price,
            showMainImageModal: false,
            showUploadedImageModal: false,
            mainImageSrc: data.image,
            get formattedPrice() {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(this.price);
            }
        };
    }

    function fileUploadHandler() {
        return {
            isDragging: false,
            image: null,
            mainImageSrc: data.image,
            selectFile() {
                this.$refs.fileInput.click();
            },
            handleDrop(event) {
                this.isDragging = false;
                this.handleFileChange(event);
            },
            handleFileChange(event) {
                this.image = event.target.files[0];
                if (this.image) {
                    this.$refs.fileInput.dispatchEvent(new Event('input'));
                }
            }
        };
    }
</script>
