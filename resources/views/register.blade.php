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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />

</head>

<body class="font-inter">
    <div class="container mx-auto lg:px-20 xl:px-32 md:px-7 sm:px-7 max-[359px]:px-3 mt-12">
        <div class="w-full max-w-5xl p-4 bg-white rounded-lg sm:p-6 md:p-8 mx-auto">
            <h5 class="text-3xl font-bold text-darkblue ml-3.5 mb-5">Register</h5>
            <form class="space-y-3.5 space-x-3.5" action="{{ route('register.submit') }}" method="POST" enctype="multipart/form-data" id="register-form">
                @csrf
                <div class="grid grid-cols-2 gap-6" data-aos="fade-up">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-normal text-gray-900">Full Name</label>
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
                                placeholder="Input Full Name" autofocus required value="{{ old('name') }}">
                        </div>
                    </div>
                    <div>
                        <label for="phone" class="block mb-2 text-sm font-normal text-gray-900">Phone Number</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="w-5 h-5 text-gray-500">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                                </svg>
                            </div>
                            <input type="text" name="phone" id="phone" placeholder="Input Phone Number"
                                class="transition duration-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                                value="{{ old('phone') }}" required>
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block mb-2 text-sm font-normal text-gray-900">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="w-5 h-5 text-gray-500"class="w-5 h-5 text-gray-500">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                    <path d="M3 7l9 6l9 -6" />
                                </svg>
                            </div>
                            <input type="text" name="email" id="email"
                                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                                placeholder="Input Email" required value="{{ old('email') }}">
                        </div>
                    </div>
                    <div>
                        <label for="idcard" class="block mb-2 text-sm font-normal text-gray-900">Identity Card <span class="text-xs text-gray-500">| PNG or JPG (max. 2MB)</span></label>
                        <div class="relative">
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                id="idcard" name="idcard" type="file" required>
                        </div>
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-normal text-gray-900">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="w-5 h-5 text-gray-500">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" />
                                    <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
                                    <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
                                </svg>
                            </div>
                            <input type="password" name="password" id="password" placeholder="Input Password"
                                class="transition duration-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                                required>
                        </div>
                    </div>
                    <div>
                        <label for="photo" class="block mb-2 text-sm font-normal text-gray-900">Self Photo <span class="text-xs text-gray-500">| PNG or JPG (max. 2MB)</span></label>
                        <div class="relative">
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                id="photo" name="photo" type="file" required>
                        </div>
                    </div>
                    <div>
                        <label for="password_confirmation" class="block mb-2 text-sm font-normal text-gray-900">Confirm Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="w-5 h-5 text-gray-500">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" />
                                    <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
                                    <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
                                </svg>
                            </div>
                            <input type="password" name="password_confirmation"
                                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                                placeholder="Confirm Password" required>
                        </div>
                    </div>
                    <div>
                        <label for="institute" class="block mb-2 text-sm font-normal text-gray-900">Institute</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="w-5 h-5 text-gray-500">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 21l18 0" />
                                    <path d="M9 8l1 0" />
                                    <path d="M9 12l1 0" />
                                    <path d="M9 16l1 0" />
                                    <path d="M14 8l1 0" />
                                    <path d="M14 12l1 0" />
                                    <path d="M14 16l1 0" />
                                    <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16" />
                                </svg>
                            </div>
                            <input type="text" name="institute" id="institute"
                                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                                placeholder="ex. Universitas Padjadjaran" required value="{{ old('institute') }}">
                        </div>
                    </div>
                    <div class="">
                        @if ($errors->any())
                        <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                            role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                            </svg>
                            <span class="sr-only">Danger</span>
                            <div>
                                <span class="font-medium">Ensure that these requirements are met:</span>
                                    <ul class="mt-1.5 list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif
                    </div>
                    <div class="">
                        <button type="submit"
                            class="w-full text-white bg-blue-700 hover:bg-blue-900 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" id="submit">Register</button>
                        <div class="mt-2">
                            <p class="text-xs text-center font-normal text-gray-400 mb-3">already have an account?</p>
                            <a href="{{ route('login')}}" class="w-full inline-block text-blue-700 bg-white border transition duration-200 hover:border-blue-700 focus:outline-none hover:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Login</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js" defer></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            AOS.init();
        });
    
        document.getElementById('register-form').addEventListener('submit', function (event) {
            const form = event.target;
    
            if (form.checkValidity()) {
                const button = document.getElementById('submit');
                button.innerHTML = '<svg aria-hidden="true" role="status" class="inline mr-2 w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"></svg>';
                button.disabled = true;
                button.classList.remove('bg-blue-700');
                button.classList.add('bg-blue-900');
            }
        });
    </script>    
</body>

</html>
