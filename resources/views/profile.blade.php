@extends('layouts.main')

@section('content')
<div class="py-16 px-32">
    <div class="grid grid-cols-2 gap-6">
        <div class="">
        </div>
        <div class="">
            <h1 class="font-semibold text-4xl py-6">Data Diri</h1>
                <h3 class="font-semibold text-lg py-3">Biodata</h3>
                <div class="grid grid-cols-3 gap-2">
                    <div class="text-md py-4">
                        <p class="py-2">Nama</p>
                        <p class="py-2">Email</p>
                        <p class="py-2">Institusi</p>
                        <p class="py-2">Kontak Nomor</p>
                    </div>
                    <div class="text-md py-4">
                        <p class="py-2">{{ auth()->user()->name }}</p>
                        <p class="py-2">{{ auth()->user()->email }}</p>
                        <p class="py-2">{{ auth()->user()->institute }}</p>
                        <p class="py-2">{{ auth()->user()->phone }}</p>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection