@extends('admin.layouts.main')

@section('content')
    <div data-aos="fade-up" class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14 w-1/2">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <nav class="flex p-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.dashboard') }}"
                                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <a href="{{ route('admin.users.index') }}"
                                    class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Manage
                                    Users</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">{{ $user->name }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <div
                    class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" id="user-update-form">
                        @csrf
                        @method('PUT')
                        <div>
                            <h5 class="mb-4 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Edit User <span class="underline decoration-blue-500">{{$user->name}}</span></h5>
                            <label for="name" class="block mb-2 text-sm font-normal text-gray-900">Full Name</label>
                            <div class="relative mb-4">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6.2V5h11v1.2M8 5v14m-3 0h6m2-6.8V11h8v1.2M17 11v8m-1.5 0h3"/>
                                      </svg>
                                </div>
                                <input type="text" name="name" id="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                                    placeholder="Input Full Name" required value="{{ old('name', $user->name) }}">
                            </div>
                            <label for="email" class="block mb-2 text-sm font-normal text-gray-900">Email</label>
                            <div class="relative mb-4">
                                <div
                                    class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
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
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                                    placeholder="Input Email" required value="{{ old('email', $user->email) }}">
                            </div>
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label for="phone" class="block mb-2 text-sm font-normal text-gray-900">Phone</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.427 14.768 17.2 13.542a1.733 1.733 0 0 0-2.45 0l-.613.613a1.732 1.732 0 0 1-2.45 0l-1.838-1.84a1.735 1.735 0 0 1 0-2.452l.612-.613a1.735 1.735 0 0 0 0-2.452L9.237 5.572a1.6 1.6 0 0 0-2.45 0c-3.223 3.2-1.702 6.896 1.519 10.117 3.22 3.221 6.914 4.745 10.12 1.535a1.601 1.601 0 0 0 0-2.456Z"/>
                                              </svg>
                                              
                                        </div>
                                        <input type="text" name="phone" id="phone"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                                            placeholder="Input phone" required value="{{ old('phone', $user->phone) }}">
                                    </div>
                                </div>
                                <div>
                                    <label for="institute" class="block mb-2 text-sm font-normal text-gray-900">Institute</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
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
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                                            placeholder="Input institute" required value="{{ old('institute', $user->institute) }}">
                                    </div>
                                </div>
                                <div class="flex-col flex">
                                    <label for="imagepreviewphoto" class="block mb-2 text-sm font-normal text-gray-900">Self Photo</label>
                                    <img src="{{ $user->photo }}" class="rounded-lg flex-grow object-cover"
                                        id="imagepreviewphoto" alt="{{ $user->name . 'photo' }}">
                                </div>
                                <div class="flex-col flex">
                                    <label for="imagepreviewidcard" class="block mb-2 text-sm font-normal text-gray-900">ID Card</label>
                                    <img src="{{ $user->idcard }}" class="rounded-lg flex-grow object-contain"
                                        id="imagepreviewidcard" alt="{{ $user->name . 'photo' }}">
                                </div>
                                <div class="flex-col flex">
                                    <label for="photo" class="block mb-2 text-sm font-normal text-gray-900">Change Self Photo (max. 2 MB | PNG, JPG)</label>
                                        <input
                                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                        id="dropzonephoto" name="photo" type="file">
                                </div>
                                <div class="flex-col flex">
                                    <label for="idcard" class="block mb-2 text-sm font-normal text-gray-900">Change ID Card (max. 2 MB | PNG, JPG)</label>
                                        <input
                                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                        id="dropzoneidcard" name="idcard" type="file">
                                </div>
                            </div>
                            <div class="mt-6">
                                <button type="submit"
                                    class="transition duration-200 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"id="submit">Update
                                    User
                                </button>
                            </div>
                        </form>
                </div>
            </div>
        </div>

        <script>
            dropzonephoto.onchange = evt => {
                const [file] = dropzonephoto.files
                if (file) {
                    imagepreviewphoto.src = URL.createObjectURL(file)
                }
            }
            dropzoneidcard.onchange = evt => {
                const [file] = dropzoneidcard.files
                if (file) {
                    imagepreviewidcard.src = URL.createObjectURL(file)
                }
            }
            document.getElementById('user-update-form').addEventListener('submit', function (event) {
            const form = event.target;
            if (form.checkValidity()) {
                const button = document.getElementById('submit');
                button.innerHTML = '<svg aria-hidden="true" role="status" class="inline w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"></svg>';
                button.disabled = true;
                button.classList.remove('bg-blue-700');
                button.classList.add('bg-blue-900');
            }
    });
        </script>
    @endsection
