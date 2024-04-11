@extends('layouts.main')

@section('content')
    <div class="container py-14 px-20">
        <h1 class="font-bold text-4xl">Hi, {{ auth()->user()->name }} 👋</h1>
        <ul>
            @foreach ($enrolledTests as $test)
                <li>{{ $test->title }}</li>
            @endforeach
        </ul>
    </div>
@endsection