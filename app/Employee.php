<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CanCreate;

class Employee extends Model
{
    protected $table ='employees';

    use CanCreate;

    public function employable()
    {
        return $this->morphTo();
    }
}
