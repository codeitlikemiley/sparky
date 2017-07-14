<?php 

namespace App\Http\Controllers;

use Validator;
use Redirect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use Session;

class UploadController extends BaseController {

    public function multiple_upload(Request $request) {
    // getting all of the post data
        $files = $request->file('image');
        // ->store('images')
    // Making counting of uploaded images
        $file_count = count($files);
    // start count how many uploaded
        $uploadcount = 0;
        foreach($files as $file) {
        $rules = array('file' => 'required|mimes:png,gif,jpeg,txt,pdf,doc');
        $validator = Validator::make(array('file'=> $file), $rules);
        if($validator->passes()){
            $destinationPath = 'uploads';
            $filename = $file->getClientOriginalName();
            $upload_success = $file->move($destinationPath, $filename);
            $uploadcount ++;
        }
        }
        if($uploadcount == $file_count){
        Session::flash('success', 'Upload successfully'); 
        return Redirect::to('upload');
        } 
        else {
        return Redirect::to('upload')->withInput()->withErrors($validator);
        }
    }
}