<?php 
namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait StoreImageTrait{

    function handleTraitUpdateImage($request, $attribute,$folderName){
        if ($request->hasFile($attribute)) { 
            // nếu có thì lấy ta file
        $file = $request->file($attribute);
        // lấy ra tên file
        $name =Str::of($file->getClientOriginalName())->slug('-');;
        //  $file->getClientOriginalExtension() vd: png phần mở rộng của file 
        // lấy tên đầy đủ
        $fileName=$name.".". $file->getClientOriginalExtension();
        // tạo đường đẫn lưu hình ảnh
        $filePath =  $file ->storeAs('public/'.$folderName.''.auth()->id(), $fileName);
        // Rest of your code
        // - storeAs: Saves the file with a specified name and location.
        // - Storage::url: Generates a URL for the stored file, 
        // which can be used to access the file publicly.
        $dataUpload=[
            "file_name"=>$fileName,
            // đổi đường dẫn
            "file_path"=> Storage::url($filePath)
        ]; 
        return $dataUpload;
    }else{
        return null;
    }
}

function  HandleTraitUploadMultiple($file,$folderName){
    $name = Str::of($file->getClientOriginalName())->slug('-');
    $fileName=$name.".". $file->getClientOriginalExtension();
    $filePath =  $file ->storeAs('public/'.$folderName.''.auth()->id(), $fileName);
// Rest of your code
   $dataUpload=[
        "file_name"=>$fileName,
        // đổi đường dẫn
        "file_path"=> Storage::url($filePath)
    ]; 
    return $dataUpload;
}
}
