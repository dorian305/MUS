<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <form id="uploadForm" enctype="multipart/form-data">
        <div>
            <label for="title">Title:</label>
            <input type="text" name="title" id="title">
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea name="description" id="description"></textarea>
        </div>
        <div>
            <label for="media">Select Media:</label>
            <input type="file" name="file[]" id="file" multiple>
        </div>
        <button type="button" onclick="submitForm()">Upload</button>
    </form>

    <script>
        function submitForm() {
            var form = document.getElementById('uploadForm');
            var formData = new FormData(form);

            formData.append('key', "9315d9b1cfd125fbe11f2fbd9590a756629d249c3a5809e77cf0d0a248481e386bafbde6a2e7e7efc7c034e9cb3a5fd29b84");

            // Make AJAX request
            fetch('/api/upload/media', {
                method: 'POST',
                body: formData,
                
            })
            .then(response => response.json())
            .then(data => {
                console.log('Response:', data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

    </script>
</body>
</html>