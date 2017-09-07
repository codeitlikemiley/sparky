<?php

namespace App\Http\Controllers\File;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditFile extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }
    
    public function __invoke($file)
    {
        if($this->getAuth()->id === $this->getTenant()->id){
            $file->name = $request->input('name');
            $file->save();
            return response()->json(['file' => $file],200);
        }
        return response()->json([],401);
    }
}
