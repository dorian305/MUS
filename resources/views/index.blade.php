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
            <textarea name="description" id="description">
            </textarea>
        </div>
        <div>
            <label for="media">Select Media:</label>
            <input type="file" name="file[]" id="file" multiple>
        </div>
        <button type="button" onclick="uploadMedia()">
            Upload
        </button>
    </form>

    <script>
        let apiKey = "";

        fetch("api/upload/generatekey", {
            method: "GET",
        })
        .then(response => response.json())
        .then(data => {
            apiKey = data['key'];
        });

        const uploadMedia = function(){
            const form = document.querySelector("#uploadForm");
            const formData = new FormData(form);

            const options = {
                method: "POST",
                headers: {
                    apiKey: apiKey,
                },
                body: formData,
            }

            fetch("api/upload/media", options)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                // ...request has succeeded.
            })
            .catch(error => {
                // ...request has failed due to an error
            });
        }
    </script>
</body>
</html>