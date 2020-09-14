<?php

namespace App\Http\Traits;

use Illuminate\Http\UploadedFile;

trait FileUpload{

  public function upload(UploadedFile $fileUploaded, $filename, $disk='public', $folder){
    
    try {
      $uploadFile = $fileUploaded->storeAs($folder, $filename, $disk);
      
      return $uploadFile;
    }catch(Exception $e){
      $errors = array("code" => $e->getCode(), "line" => $e->getLine(), "file" => $e->getFile());
      Log::info($errors);
      Log::error($e->getMessage());
      return null;
    }
  }

}