<?php

namespace App\Traits\ModelBuilder;

use App\Traits\Permissions\OwnsByTenant;
use App\Traits\Mutators\UsersMutator;
use App\Traits\StaticFunctions\UserStaticFunctions;
use App\Traits\MorphTo\Clientable;
use App\Traits\Permissions\CanComment;

trait ClientBuilder {
    use OwnsByTenant, UsersMutator, UserStaticFunctions, 
    Clientable, CanComment;
}