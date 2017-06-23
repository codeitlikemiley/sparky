<?php

namespace App\Traits\ModelBuilder;

use BrianFaust\Commentable\HasComments;
use App\Traits\Methods\LoggersMethod;

trait TaskBuilder {
    use HasComments, LoggersMethod;
}