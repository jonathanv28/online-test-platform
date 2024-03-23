<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Online Test Platform</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <div class="jumbotron">
            <h3>Validasi Wajah</h3>
        </div>
    
        @if(session('success'))
            <div class="alert alert-success">
                <div class="form-group">{{ session('success') }}</div>
                <a href="/" class="btn btn-success">Try Again</a>
            </div>
        @endif
    
        @if(isset($results))
            {{ dd($results) }}
        @else
            <form action="/validate" method="post" enctype="multipart/form-data">
                @csrf
                <label class="block mb-2 text-sm font-medium text-gray-900" for="photo">Upload a Photo</label>
                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" id="photo" type="file" name="photo1">

                <!-- <div class="form-group">
                    <label for="photo">Upload a Photo</label>
                    <input type="file" name="photo2" id="photo" class="form-control">
                </div> -->
                <div id="webcam-container">
                    <!-- Webcam preview will be shown here -->
                </div>
                <input type="hidden" name="image" id="captured-image">
                <div class="form-group">
                    <input type="submit" value="Submit" class="btn btn-success btn-lg" ">
                </div>
            </form>
        @endif
    
    </div>
    <script language="JavaScript">
        Webcam.set({
            width: 320,
            height: 240,
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
                // Encode the captured image data as base64
                var base64Image = data_uri.split(',')[1];
                document.getElementById('captured-image').value = base64Image;
            });
        }
    </script>
</body>
</html>
