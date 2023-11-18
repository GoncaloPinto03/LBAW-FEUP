<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public static function create(int $id, string $type, Request $request) 
    {
        if ($request->file('image')) {
            $file= $request->file('image');
            $filename= $id.".jpg";
            $file->move(public_path('images/'. $type. '/'), $filename);
        }
    }

    public static function delete(int $id, string $type) {
        foreach ( glob(public_path().'/images/'.$type.'/'.$id.'.*',GLOB_BRACE) as $image){
            if (file_exists($image)) unlink($image);
        }
    }

    public static function update(int $id, string $type, Request $request) {
        if ($request->file('image')) {
            PhotoController::delete($id, $type);
            PhotoController::create($id, $type, $request);
        }
    }

}
