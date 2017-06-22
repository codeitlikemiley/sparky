<?php

namespace App\Traits\ModelBuilder;

use App\Traits\Permissions\OwnsByTenant;
use App\Traits\Permissions\CanCreateProjects;
use App\Traits\Permissions\AllowedProjects;
use App\Traits\Mutators\UsersMutator;
use App\Traits\StaticFunctions\UserStaticFunctions;
use App\Traits\Permissions\CanComment;
use App\Traits\MorphTo\Employable;

trait EmployeeBuilder {
    use OwnsByTenant, CanCreateProjects, AllowedProjects,
        UsersMutator, UserStaticFunctions,
        CanComment, Employable;
}