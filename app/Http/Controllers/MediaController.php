<?php

namespace App\Http\Controllers;

use App\Models\ApiKeys;
use App\Models\Media;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Services\ValidateAPIKey;

class MediaController extends Controller
{
    private $uploadDir = "media";
    private $filesSuccessfullyUploaded = [];
    private $filesUnsuccessfullyUploaded = [];
    private $allowedFileTypes = [
        "jpeg", "jpg", "png", "gif", // Image extensions
        "mp4", "avi", "mov", "mkv",  // Video extensions
    ];
    private $validationRules = [
        'title'         =>  "required",
        'description'   =>  "required",
        'file'          =>  "required",
    ];



    private function validateRequest(Array $data) : Array
    {
        $details = [
            'status'    =>  "success",
            'errors'    =>  [],
        ];
        $validator = Validator::make($data, $this->validationRules);

        if ($validator->fails()){
            $details['status'] = "error";
            $details['errors'] = $validator->errors();
        }

        return $details;
    }


    public function upload(Request $request) : JsonResponse
    {
        // Retrieve all data from the request
        $data = $request->all();

        // Validate API Key
        $validKey = ValidateAPIKey::validate($request->header('apiKey'), "api/upload/media");
        if (!$validKey){
            $returnData = [
                'error' => "Invalid key provided.",
            ];
    
            return response()->json($returnData, 403);
        }

        // Validate required parameters
        $validationDetails = $this->validateRequest($data);
        if ($validationDetails['status'] === "error"){
            $returnData = [
                'message'   =>  "Invalid data.",
                'errors'    =>  $validationDetails['errors'],
            ];
    
            return response()->json($returnData, 422);
        }


        // Iterate over each uploaded file
        foreach ($request->file('file') as $file){
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getSize(); // Size is in bytes
            $fileMime = $file->getMimeType();
            $fileType = explode("/", $fileMime)[1];

            $fileHasUnsupportedFileType = !in_array($fileType, $this->allowedFileTypes);
            if ($fileHasUnsupportedFileType){
                $fileData = [
                    'fileName'  =>  $fileName,
                    'fileType'  =>  $fileType,
                    'error'     =>  "Unsupported file type!",
                ];

                array_push($this->filesUnsuccessfullyUploaded, $fileData);
                continue;
            };


            // Save the uploaded file to the directory and store information about the file
            // into the database
            try {
                $pathToTheFile = $this->storeFile($file);

                $newMedia = new Media();
                $newMedia->title =          $data['title'];
                $newMedia->description =    $data['description'];
                $newMedia->file_type =      $fileType;
                $newMedia->file_size =      $fileSize;
                $newMedia->file_path =      $pathToTheFile;
                $newMedia->save();

                $fileData = [
                    'fileName' => $fileName,
                    'fileType' => $fileType,
                    'fileSize' => $fileSize,
                    'filePath' => $pathToTheFile,
                ];

                array_push($this->filesSuccessfullyUploaded, $fileData);
            }

            catch (Exception $e) {
                $fileData = [
                    'fileName'  =>  $fileName,
                    'error'     =>  "An error occured while trying to upload the file: {$e->getMessage()}",
                ];

                array_push($this->filesUnsuccessfullyUploaded, $fileData);
            }
        }

        $returnData = [
            'filesUploaded'     => $this->filesSuccessfullyUploaded,
            'filesNotUploaded'  => $this->filesUnsuccessfullyUploaded,
        ];
        if (count($this->filesUnsuccessfullyUploaded) > 0){
            $returnData['error'] = "Some files couldn't be uploaded. Please check 'filesNotUploaded' for more information.";
        }

        else {
            $returnData['message'] = "Files uploaded successfully.";
        }

        return new JsonResponse(
            data: $returnData,
            status: 200,
        );
    }


    private function storeFile($file) : String
    {
        $filePath = Storage::disk('local')->putFile($this->uploadDir, $file);
        $fullPath = "storage/{$filePath}";

        return $fullPath;
    }
}