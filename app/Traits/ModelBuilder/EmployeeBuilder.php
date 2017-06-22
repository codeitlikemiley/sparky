<?php

namespace App\Traits\ModelBuilder;

use App\Traits\Relationship\ByTenant;
use App\Traits\Relationship\HasProjects;
use App\Traits\Relationship\AssignedProjects;
use App\Traits\Mutators\UsersMutator;
use App\Traits\Methods\UsersMethod;
use App\Traits\Relationship\HasComments;
use App\Traits\MorphTo\Employable;

trait EmployeeBuilder {
    use ByTenant, HasProjects, AssignedProjects,
        UsersMutator, UsersMethod,
        HasComments, Employable;
}