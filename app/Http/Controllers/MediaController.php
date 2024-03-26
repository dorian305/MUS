<?php

namespace App\Http\Controllers;

use App\Models\ApiKeys;
use App\Models\Media;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    private $uploadDir = "media";
    private $maxFileSize = 10; // In megabytes
    private $filesSuccessfullyUploaded = [];
    private $filesUnsuccessfullyUploaded = [];
    private $allowedFileTypes = [
        'jpeg', 'jpg', 'png', 'gif', // Image extensions
        'mp4', 'avi', 'mov', 'mkv',  // Video extensions
    ];
    private $validationRules = [
        'title'         =>  'required',
        'description'   =>  'required',
        'file'          =>  'required',
        'key'           =>  'required',
    ];



    private function validateRequest($data)
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


    private function validateAPIKey($key)
    {
        $resultKeysObj = ApiKeys::where('endpoint', "/upload/media")->get();
        foreach ($resultKeysObj as $keyObj){
            if (Hash::check($key, $keyObj->key)) return true;
        }

        return false;
    }



    public function upload(Request $request)
    {
        // Retrieve all data from the request
        $data = $request->all();

        $validationDetails = $this->validateRequest($data);
        if ($validationDetails['status'] === "error"){
            $returnData = [
                'message'   =>  "Invalid data.",
                'errors'    =>  $validationDetails['errors'],
            ];
    
            return response()->json($returnData, 422);
        }

        $validKey = $this->validateApiKey($data['key']);
        if (!$validKey){
            $returnData = [
                'error' => "Invalid key provided.",
            ];
    
            return response()->json($returnData, 403);
        }

        // Iterate over each uploaded file
        foreach ($request->file('file') as $file){
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getSize(); // Size is in bytes
            $fileMime = $file->getMimeType();
            $fileType = explode('/', $fileMime)[1];

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

            // Implement allowed filesize check...

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

        return response()->json($returnData, 200);
    }


    private function storeFile($file)
    {
        $filePath = Storage::disk('local')->putFile($this->uploadDir, $file);
        $fullPath = "storage/{$filePath}";

        return $fullPath;
    }
}