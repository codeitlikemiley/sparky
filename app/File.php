<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelBuilder\FileBuilder;

class File extends Model
{
    use FileBuilder;
}
