# Outdated documentation, don't read.
# Will be updated when I complete the project.

<!-- # Description
This document provides information on the API.
The API is created using Laravel framework. It is a private API, requiring a valid key in order to use it.
The key can be obtained by making a request to another endpoint.
It is designed to handle media uploads, requiring a title, description and a list of media files to be uploaded.
Returns an array of files that were uploaded with their name, type, size and path, and also array of files that failed to upload with their name and the error why the upload failed.




# Endpoints
## Api key generation
- URL: `api/upload/generatekey`
- Method: GET
- Description:
    - Generates a 100-character API key.
- Response:
    - JSON containing the generated key.



## Media upload
- URL: `api/upload/media`
- Method: POST
- Description:
    - Uploads media files to the backend storage.
    - Allowed file types are: ['jpeg', 'jpg', 'png', 'gif', 'mp4', 'avi', 'mov', 'mkv']
    - Stores title, description, type, size and path of the file to the table.
    - Title and description are stored same for all uploaded files in the table
    - Requires a valid API key.
- Request parameters:
    - title: Title of the media (string, required).
    - description: Description of the media (string, required).
    - file[]: Media file(s) to upload (array of files, required).
    - apiKey: Valid api key which must be attached to the header of the request.
- Response:
    - Success:
        - Status Code: 200
        - JSON response containing information about successfully uploaded files and any files that were not uploaded due to errors.
    - Errors:
        - JSON response containing error message(s).
        - Possible errors are:
            - 422 (Invalid data, missing required parameters)
            - Invalid api key provided



## How to generate api key
- To generate an API key, make a GET request to `api/upload/generatekey`.
- This endpoint will return a JSON response containing the generated key.
- Store the key.

### Usage
```
let apiKey = "";

fetch('/upload/generatekey', {
    method: "GET",
})
.then(response => response.json())
.then(data => {
    apiKey = data['key'];
});
```



## How to upload media
- Obtain a valid API key from the endpoint above.
- Construct a `multipart/form-data` form with the required parameters as inputs.
- Make a POST request to the `api/upload/media` endpoint using javascript and make sure to attach the API key to the head of the request.

### Usage
```
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
    const uploadMedia = function(){
        const form = document.querySelector("#uploadForm");
        const formData = new FormData(form);

        const options = {
            method: "POST",
            headers: {
                apiKey: 'yourApiKey',
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
```


### Response
```
All files successfully uploaded
{
    'filesUploaded': [
        [
            'fileName' => uploaded file name,
            'fileType' => file type,
            'fileSize' => file size,
            'filePath' => path to the file,
        ],
        ...,
        ...,
    ],
    'filesNotUploaded': [],
};


Some files failed to upload
{
    'filesUploaded': [
        [
            'fileName' => uploaded file name,
            'fileType' => file type,
            'fileSize' => file size,
            'filePath' => path to the file,
        ],
        ...,
        ...,
    ],
    'filesNotUploaded': [
        [
            'fileName'  =>  $fileName,
            'error'     =>  "An error occured while trying to upload the file: error that occured for that file",
        ],
        ...,
        ...
    ],
    'error': "Some files couldn't be uploaded. Please check 'filesNotUploaded' for more information."
}

All files failed to upload
{
    'filesUploaded': [],
    'filesNotUploaded': [
        [
            'fileName'  =>  $fileName,
            'error'     =>  "An error occured while trying to upload the file: error that occured for that file",
        ],
        ...,
        ...
    ],
    'error': "Some files couldn't be uploaded. Please check 'filesNotUploaded' for more information."
}
``` -->