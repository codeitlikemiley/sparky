<?php

namespace App\Traits\ModelBuilder;

use BrianFaust\Commentable\HasComments;
use Spatie\Activitylog\Traits\LogsActivity;

trait TaskBuilder {
    use HasComments, LogsActivity;
}