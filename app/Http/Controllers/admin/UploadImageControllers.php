<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Traits\StoreImageTrait;
use Illuminate\Http\Request;

class UploadImageControllers extends Controller
{
    use StoreImageTrait;
    public function uploadImage(Request $request){
        try {
            $fileImage = $request->file('image'); 
            $image = $this->HandleTraitUploadMultiple($fileImage, 'customer-storage');
            return response()->json(['code' => 200, 'image' => $image["file_path"]]);
        } catch (\Throwable $th) {
            dd( $th->getMessage());
            return response()->json(['code' => 500, 'message' => $th->getMessage()]);
        }
    }
}
