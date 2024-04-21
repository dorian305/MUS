<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use App\Services\ValidateAPIKey;
use App\Services\MediaUpload;
use App\Services\ValidateRequest;

class MediaController extends Controller
{
    private Array $filesSuccessfullyUploaded = [];
    private Array $filesUnsuccessfullyUploaded = [];
    private String $uploadDir = "media";
    private Array $allowedFileTypes = [
        "jpeg", "jpg", "png", "gif", // Image extensions
        "mp4", "avi", "mov", "mkv",  // Video extensions
    ];
    private Array $expectedData = [
        'apiKey'        =>  "required",
        'title'         =>  "required",
        'description'   =>  "required",
        'file'          =>  "required",
    ];


    public function upload(Request $request) : JsonResponse
    {
        // Retrieve all data from the request
        $data = $request->all();
        $data['apiKey'] = $request->header('apiKey');

        $validationDetails = ValidateRequest::validateData($data, $this->expectedData);
        if ($validationDetails['success'] === false){
            $returnData = [
                'message'   =>  "Invalid data.",
                'errors'    =>  $validationDetails['errors'],
            ];

            return new JsonResponse(
                data: $returnData,
                status: 422,
            );
        }

        $validKey = ValidateAPIKey::validate($data['apiKey'], "api/upload/media");
        if (!$validKey){
            $returnData = [
                'error' => "Invalid key provided.",
            ];
    
            return new JsonResponse(
                data: $returnData,
                status: 403,
            );
        }

        // Iterate over each uploaded file
        foreach ($request->file('file') as $file){
            $fileData = $this->getFileData($file);

            $fileHasUnsupportedFileType = !in_array($fileData['type'], $this->allowedFileTypes);
            if ($fileHasUnsupportedFileType){
                array_push($this->filesUnsuccessfullyUploaded, [
                    'name'  =>  $fileData['name'],
                    'type'  =>  $fileData['type'],
                    'error' =>  "Unsupported file type!",
                ]);

                continue;
            };

            $uploadResult = MediaUpload::uploadFile($file, $this->uploadDir, $this->allowedFileTypes);
            if ($uploadResult['success'] === false){
                array_push($this->filesUnsuccessfullyUploaded, [
                    'name'  => $fileData['name'],
                    'error' => $uploadResult['error'],
                ]);

                continue;
            }

            $this->saveFileDataToDatabase($data['title'], $data['description'], $fileData['type'], $fileData['size'], $uploadResult['fullPath']);

            $fileData['path'] = $uploadResult['fullPath'];
            array_push($this->filesSuccessfullyUploaded, $fileData);
        }


        $response = $this->constructResponse();

        return new JsonResponse(
            data: $response,
            status: 200,
        );
    }


    private function getFileData(UploadedFile $file) : Array
    {
        $data = [
            'name'  => $file->getClientOriginalName(),
            'type'  => explode("/", $file->getMimeType())[1],
            'size'  => $file->getSize(), // Size is in bytes
            'mime'  => $file->getMimeType(),
        ];
        
        return $data;
    }


    private function saveFileDataToDatabase(String $title, String $description, String $type, Int $size, String $path) : void
    {
        $newMedia = new Media();
        $newMedia->title =          $title;
        $newMedia->description =    $description;
        $newMedia->file_type =      $type;
        $newMedia->file_size =      $size;
        $newMedia->file_path =      $path;

        $newMedia->save();
    }


    private function constructResponse() : Array
    {
        $response = [];

        $response['filesUploaded'] = $this->filesSuccessfullyUploaded;
        $response['filesNotUploaded'] = $this->filesUnsuccessfullyUploaded;

        $someFilesWereNotUploaded = count($this->filesUnsuccessfullyUploaded) > 0;
        $someFilesWereNotUploaded ?
        $response['error'] = "Some files couldn't be uploaded. Please check 'filesNotUploaded' for more information." :
        $response['message'] = "Files uploaded successfully.";

        return $response;
    }
}