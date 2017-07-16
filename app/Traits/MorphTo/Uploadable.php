<?php 

namespace App\Traits\MorphTo;

trait Uploadable
{
    public function uploadable()
    {
        return $this->morphTo();
    }
}