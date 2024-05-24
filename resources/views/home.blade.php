@extends('layouts.app')

@section('content')
<div
class="flex items-center lg:h-[calc(100vh-5rem)] mx-auto container flex-col-reverse lg:flex-row lg:justify-between px-4 sm:px-6 lg:px-8">
<div class="flex flex-col space-y-6">
    <div class="space-y-3">
        @auth
            <p class="text-gray-500">Halo {{ Auth::user()->name }}, apa kabar?</p>
        @endauth
        <h1 class="text-4xl md:text-6xl lg:max-w-xl drop-shadow font-bold">Temukan <span
                class="text-[#33CD99]">Jasa</span> yang anda
            butuhkan di Jasafy! </h1>
    </div>

    <div class="flex items-center flex-col lg:flex-row gap-5">
        @auth
            <a class="rounded hover:from-[#33CD99] to-[#33CD99] bg-gradient-to-r hover:to-[#33cd6e] from-[#33cd6e] text-white px-10 py-2 w-full lg:w-fit text-center" href="/services">Telusuri Jasa</a>
        @else
            <a class="rounded hover:from-[#33CD99] to-[#33CD99] bg-gradient-to-r hover:to-[#33cd6e] from-[#33cd6e] text-white px-10 py-2 w-full lg:w-fit text-center"
                href={{ route("register") }}>Register</a>
            <a class="rounded hover:from-[#33CD99] to-[#33CD99] bg-gradient-to-r hover:to-[#33cd6e] from-[#33cd6e] text-white px-10 py-2 w-full lg:w-fit text-center"
            href={{ route("login") }}>Login</a>
        @endauth
    </div>
</div>

<img class="lg:h-[32rem] w-full h-96 lg:w-[48rem] rounded shadow object-cover"
    src="https://images.unsplash.com/photo-1600880292089-90a7e086ee0c?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
    alt="landing">
</div>
@endsection
