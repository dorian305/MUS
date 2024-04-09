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
        let apiKey = "3df3b40d4b990af768dd176a3262f2df8c1dadce7797988ba8d0c82b684f98667ec8fa99a31784be4399f5e5dae4980fb3ee";

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