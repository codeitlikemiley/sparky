<?php

namespace App\Traits\ModelBuilder;

use App\Traits\Permissions\CanCreateProjects;
use App\Traits\Permissions\OwnsByTenant;
use App\Traits\MorphTo\Employable;
use App\Traits\Mutators\UsersMutator;
use App\Traits\StaticFunctions\UserStaticFunctions;
use App\Traits\Permissions\CanComment;

trait EmployeeBuilder {
    use CanCreateProjects,
        OwnsByTenant, Employable,
        UsersMutator, UserStaticFunctions,
        CanComment;
}