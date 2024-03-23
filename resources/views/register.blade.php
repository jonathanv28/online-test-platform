<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>

    {{-- Tailwind CSS --}}
    <link href="/css/app.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    {{-- Font Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    {{-- AOS CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

</head>

<body class="font-inter">
    <div class="container mx-auto lg:px-20 xl:px-32 md:px-7 sm:px-7 max-[359px]:px-3 mt-12">
        <div class="w-full max-w-5xl p-4 bg-white rounded-lg sm:p-6 md:p-8 mx-auto">
            @if (session()->has('loginError'))
                <div id="alert-2" class="flex p-4 mb-4 text-red-700 bg-red-100 rounded-lg" role="alert">
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('loginError') }}
                    </div>
                    <button type="button"
                        class="ml-auto -mx-1.5 -my-1.5 bg-red-100 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8"
                        data-dismiss-target="#alert-2" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            @endif

            <h5 class="text-3xl font-bold text-darkblue ml-3.5 mb-5">Daftar</h5>
            <form class="space-y-3.5 space-x-3.5" action="/login" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-normal text-gray-900">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="w-5 h-5 text-gray-500">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                    <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                    <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                                </svg>
                            </div>
                            <input type="text" name="name" id="name"
                                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                                placeholder="ex. John Doe" autofocus required>
                            @error('name')
                                <div class="mt-2 text-xs text-red-600font-normal">
                                    {{ $message }}
                                </div>
                            </div>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="phone" class="block mb-2 text-sm font-normal text-gray-900">Nomor Kontak
                        (Opsional)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                            <svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="w-5 h-5 text-gray-500">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                            </svg>
                        </div>
                        <input type="text" name="phone" id="phone" placeholder="08xxxxx"
                            class="transition duration-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5">
                    </div>
                </div>
                <div>
                    <label for="email" class="block mb-2 text-sm font-normal text-gray-900">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                            <svg  xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="w-5 h-5 text-gray-500"class="w-5 h-5 text-gray-500">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                <path d="M3 7l9 6l9 -6" />
                            </svg>
                        </div>
                        <input type="text" name="email" id="email"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                            placeholder="ex. name@example.com" required>
                        @error('email')
                            <div class="mt-2 text-xs text-red-600font-normal">
                                {{ $message }}
                            </div>
                        </div>
                    @enderror
                </div>
        </div>
        <div>
            <label for="idcard" class="block mb-2 text-sm font-normal text-gray-900">Kartu
                Identitas</label>
            <div class="relative">
                <input
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                    id="idcard" name="idcard" type="file" required>
                @error('idcard')
                    <div class="mt-2 text-xs text-red-600font-normal">
                        {{ $message }}
                    </div>
                </div>
            @enderror
        </div>
    </div>
    <div>
        <label for="password" class="block mb-2 text-sm font-normal text-gray-900">Password</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-gray-500">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" />
                    <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
                    <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
                </svg>
            </div>
            <input type="password" name="password" id="password" placeholder="••••••••"
                class="transition duration-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                required>
        </div>
    </div>
    <div>
        <label for="photo" class="block mb-2 text-sm font-normal text-gray-900">Foto Diri</label>
        <div class="relative">
            <input
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                id="photo" name="photo" type="file" required>

            @error('photo')
                <div class="mt-2 text-xs text-red-600 font-normal">
                    {{ $message }}
                </div>
            </div>
        @enderror
    </div>
    </div>
    <div>
        <label for="repassword" class="block mb-2 text-sm font-normal text-gray-900">Konfirmasi Password</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-gray-500">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" />
                    <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
                    <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
                </svg>
            </div>
            <input type="password" name="repassword" id="repassword"
                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                placeholder="••••••••" required>
            @error('repassword')
                <div class="mt-2 text-xs text-red-600font-normal">
                    {{ $message }}
                </div>
            </div>
        @enderror
    </div>
    </div>
    <div>
        <label for="institute" class="block mb-2 text-sm font-normal text-gray-900">Institusi</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                <svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="w-5 h-5 text-gray-500"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 21l18 0" /><path d="M9 8l1 0" /><path d="M9 12l1 0" /><path d="M9 16l1 0" /><path d="M14 8l1 0" /><path d="M14 12l1 0" /><path d="M14 16l1 0" /><path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16" /></svg>
            </div>
            <input type="text" name="institute" id="institute"
                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                placeholder="ex. Universitas Padjadjaran" required>
            @error('institute')
                <div class="mt-2 text-xs text-red-600font-normal">
                    {{ $message }}
                </div>
            </div>
        @enderror
    </div>
    <div class="mt-7">
        <button type="submit"
            class="w-full text-white bg-grass hover:bg-grassbold focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Daftar</button>
    </div>
    <div class="mt-3">
        <p class="text-xs text-center font-normal text-gray-400 mb-3">sudah mempunyai akun?</p>
        <button
            class="w-full text-grass bg-white border transition duration-200 hover:border-grass focus:outline-none hover:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Masuk</button>
    </div>
    </div>
    </form>

    </div>
    </div>


    {{-- Flowbite Js --}}
    <script src="https://unpkg.com/flowbite@1.6.0/dist/flowbite.min.js"></script>
</body>

</html>
