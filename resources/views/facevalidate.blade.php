@extends('layouts.main')

@section('content')
    <div class="container mx-auto pt-16">
        <h1 class="text-center font-bold text-4xl mb-8">Validasi Wajah</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (isset($results))
            {{ dd($results) }}
        @else
            <form action="/validate" method="POST" class="text-center mx-auto w-2/5" enctype="multipart/form-data">
                @csrf
                <div id="webcam-container" class="mb-6">
                    <!-- Webcam preview will be shown here -->
                </div>
                <input type="hidden" name="image" id="captured-image">
                <div class="">
                    <input type="submit" value="Submit"
                        class="w-full text-white bg-grass hover:bg-grassbold focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                </div>
            </form>
        @endif

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <script language="JavaScript">
        Webcam.set({
            width: 640,
            height: 360,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        Webcam.attach('#webcam-container');

        document.querySelector('form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form submission
            captureImage();
            this.submit(); // Submit the form after capturing the image
        });

        function captureImage() {
            Webcam.snap(function(data_uri) {
            // Display the captured image on the page
            var image = document.createElement('img');
            image.src = data_uri;
            document.body.appendChild(image);

            // Encode the captured image data as base64
            var base64Image = data_uri.split(',')[1];
            document.getElementById('captured-image').value = base64Image;
        });
        }
    </script>
@endsection
