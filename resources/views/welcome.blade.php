<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload using Krajee File Input Plugin</title>
    <!--  CSS files -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.2.8/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

</head>
<body>

    <div class="container">
        <input id="input-id" name="input-name[]" type="file" class="file" data-preview-file-type="text" multiple>
        <button id="upload-button" class="btn btn-primary">Upload File</button>
    </div>


    <!--  Show image -->
    <div class="container mt-4">
<table class="table table-bordered">
        <thead>
            <tr>
            <th scope="col">Id</th>
            <th scope="col">Image</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($file_data as $data)
        <tr>
        <th scope="row">{{ $loop->index + 1 }}</th>

            <td><img src="{{ asset('storage/uploads/' . $data->image)) }}"  height="50px" width="50px" alt="image"/></td>
            <td>

            <a class="btn btn-danger" href="#" class="delete-link" data-id="{{encrypt($data->id) }}">Delete</a>

            <a class="btn btn-warning" href="{{ Storage::url('uploads/' . $data->image) }}" download>Download</a>

            </td>
        </tr>
        @endforeach




            </tr>
        </tbody>
</table>
</div>

    <!-- JavaScript files -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.2.8/js/fileinput.min.js"></script>
    <!-- Initialize the plugin -->
    <script>
        $(document).ready(function() {
            // Initialize file input plugin
            $("#input-id").fileinput();

            // Handle file upload button click event
            $("#upload-button").click(function() {
                // Get the selected file(s)
                var files = $("#input-id").prop("files");
                // Create a FormData object to send the file data to the server
                var formData = new FormData();
                // Append the file(s) to the FormData object
                for (var i = 0; i < files.length; i++) {
                    formData.append("files[]", files[i]);
                }
                // Send the file data to the server using AJAX
                $.ajax({
                    url: "{{ route('upload') }}", // Replace "your-upload-url.php" with the URL of your server-side upload script
                    type: "POST",
                    data: formData,
                    processData: false, // Prevent jQuery from automatically processing the data
                    contentType: false, // Prevent jQuery from automatically setting the content type
                    success: function(response) {
                        // Handle the server response here (e.g., display upload status)
                        $("#upload-status").html(response);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Handle errors here
                        console.log("Error:", error);
                    }
                });
            });
        });


        //  Delete Data

     $(document).ready(function() {
    $('.delete-link').on('click', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        // alert(id);
        var url = "{{ route('delete', ['id' => ':id']) }}".replace(':id', id);
            //    alert(url);
        if(confirm("Are you sure you want to delete this record?")) {
            $.ajax({

                url:url,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response.message);
                    location.reload();

                },
                error: function(xhr, status, error) {
                    console.error(error);

                }
            });
        }
    });
});
    </script>
</body>
</html>
