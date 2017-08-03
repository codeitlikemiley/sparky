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
    
    public function __invoke()
    {
        return 'file name editted';
    }
}
