<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel + AWS Rekognition</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
</head>
<body>
    <div class="container">

        <div class="jumbotron">
            <h3>Try Laravel + AWS Rekognition SDK Integration</h3>
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
            <form action="/" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="confidence">Minimum Confidence</label>
                    <input type="number" id="confidence" name="confidence" class="form-control" value="50">
                </div>
                <div class="form-group">
                    <label for="photo">Upload a Photo</label>
                    <input type="file" name="photo1" id="photo" class="form-control">
                </div>
                <div class="form-group">
                    <label for="photo">Upload a Photo</label>
                    <input type="file" name="photo2" id="photo" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" value="Submit" class="btn btn-success btn-lg">
                </div>
            </form>
        @endif
    
    </div>
</body>
</html>