<?php

namespace App\Traits\ModelBuilder;

use App\Traits\Relationship\ByTenant;
use App\Traits\Relationship\HasProjects;
use App\Traits\Relationship\AssignedSubtasks;
use App\Traits\Mutators\UsersMutator;
use App\Traits\Methods\UsersMethod;
use App\Traits\Relationship\HasComments;
use App\Traits\MorphTo\Employable;
use App\Traits\Relationship\HasActivities;
use App\Traits\Relationship\EmployeeHasSubtasks;
use App\Traits\Relationship\CanManageProjects;

trait EmployeeBuilder {
    use ByTenant, HasProjects, AssignedSubtasks,
        UsersMutator, UsersMethod,
        HasComments, Employable, HasActivities,
        EmployeeHasSubtasks, CanManageProjects;
}