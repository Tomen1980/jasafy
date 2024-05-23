@extends('layouts.app')

@section('content')
    <div class="h-96 w-full to-[#33CD99] bg-gradient-to-r from-[#33cd6e] relative">
        <div
            class="container mx-auto px-4 h-full flex lg:items-center justify-center lg:justify-start flex-col-reverse lg:flex-row gap-5">
            <div class="space-y-6 z-30 lg:z-[initial]">
                <h1 class="font-bold text-2xl md:text-4xl text-white">Jasafy</h1>
                <h5 class="text-white md:text-lg italic">Where skills meet opportunity</h5>
                <p
                    class="text-white lg:max-w-lg text-sm lg:text-base text-justify overflow-y-auto max-h-36 lg:max-h-[initial]">
                    Jelajahi berbagai kategori layanan kami dan temukan penyedia jasa
                    terampil yang siap memenuhi setiap tuntutan Anda. Dari layanan teknis hingga kreatif, kami telah
                    menyusun pilihan jasa yang beragam untuk memastikan kebutuhan unik Anda dapat terpenuhi dengan mudah.
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

    <div class="container mx-auto px-4" x-data="servicesData()">
        <h1 class="text-3xl font-bold my-6">Services</h1>

        <!-- Button to open the modal -->
        @if (Auth::user() && Auth::user()->role === 'seller')
            <button @click="openModal()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Add Service
            </button>
        @endif

        <!-- Services list -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($services as $service)
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold">{{ $service->title }}</h2>
                    <p class="mt-2">{{ $service->description }}</p>
                    <p class="mt-2 text-sm text-gray-600">Location: {{ $service->location }}</p>
                    @if (Auth::user() && Auth::user()->role === 'seller')
                        <button @click="openModal({{ $service }})"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">
                            Edit
                        </button>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Modal for adding/editing a service -->
        <div x-show="open" @click.away="closeModal()"
            class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
                <h2 class="text-2xl font-bold mb-4" x-text="isEditMode ? 'Edit Service' : 'Add Service'"></h2>
                <form @submit.prevent="saveService()">
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                        <input type="text" x-model="form.title" id="title"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                        <textarea x-model="form.description" id="description"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="location" class="block text-gray-700 text-sm font-bold mb-2">Location</label>
                        <input type="text" x-model="form.location" id="location"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Save
                        </button>
                        <button type="button" @click="closeModal()"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function servicesData() {
            return {
                open: false,
                isEditMode: false,
                // services: [
                //     { id: 1, title: 'Service 1', description: 'Description 1', location: 'Location 1' },
                //     { id: 2, title: 'Service 2', description: 'Description 2', location: 'Location 2' },
                //     { id: 3, title: 'Service 3', description: 'Description 3', location: 'Location 3' }
                // ],
                form: {
                    id: null,
                    title: '',
                    description: '',
                    location: ''
                },
                openModal(service = null) {
                    this.resetForm();
                    if (service) {
                        this.isEditMode = true;
                        this.form = {
                            ...service
                        };
                    } else {
                        this.isEditMode = false;
                    }
                    this.open = true;
                },
                closeModal() {
                    this.open = false;
                },
                resetForm() {
                    this.form = {
                        id: null,
                        title: '',
                        description: '',
                        location: ''
                    };
                },
                // saveService() {
                //     if (this.isEditMode) {
                //         const index = this.services.findIndex(s => s.id === this.form.id);
                //         this.services[index] = { ...this.form };
                //     } else {
                //         const newService = { ...this.form, id: this.services.length + 1 };
                //         this.services.push(newService);
                //     }
                //     this.closeModal();
                // }
            };
        }
    </script>
@endsection
