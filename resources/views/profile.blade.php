@extends('layouts.main')

@section('content')
<div class="py-16 px-32" data-aos="fade-up">
    <div class="grid grid-cols-3 gap-6">
        <div class="flex-col flex">
            <img src="{{ auth()->user()->idcard }}" class=" mx-auto w-2/3 rounded-lg flex-grow object-contain"
                id="imagepreviewidcard" alt="{{ auth()->user()->name . 'photo' }}">
        </div>
        <div class="flex-col flex">
            <img src="{{ auth()->user()->photo }}" class=" mx-auto w-2/3 rounded-lg flex-grow object-cover"
                id="imagepreviewphoto" alt="{{ auth()->user()->name . 'photo' }}">
        </div>
        <div class="my-auto">
            <h1 class="font-semibold text-4xl py-6">Profile</h1>
                <h3 class="font-semibold text-lg py-3">Biodata</h3>
                <div class="grid grid-cols-3 gap-2">
                    <div class="text-md py-4">
                        <p class="py-2">Name</p>
                        <p class="py-2">Email</p>
                        <p class="py-2">Institusi</p>
                        <p class="py-2">Kontak Nomor</p>
                    </div>
                    <div class="text-md py-4">
                        <p class="py-2 font-light">{{ auth()->user()->name }}</p>
                        <p class="py-2 font-light">{{ auth()->user()->email }}</p>
                        <p class="py-2 font-light">{{ auth()->user()->institute }}</p>
                        <p class="py-2 font-light">{{ auth()->user()->phone }}</p>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection