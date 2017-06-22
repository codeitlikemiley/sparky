<?php

namespace App\Traits\ModelBuilder;

use App\Traits\Permissions\CanCreateClients;
use App\Traits\Permissions\CanCreateEmployees;
use App\Traits\Permissions\CanCreateProjects;
use App\Traits\Permissions\CanManageClients;
use App\Traits\Permissions\CanManageEmployees;
use App\Traits\Permissions\CanManageProjects;
use App\Traits\Mutators\UsersMutator;
use App\Traits\StaticFunctions\UserStaticFunctions;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use App\Traits\Sluggable\UserSluggable;
use App\Traits\Permissions\CanComment;

trait UserBuilder {
    use CanCreateClients, CanCreateEmployees, CanCreateProjects,
        CanManageClients, CanManageEmployees, CanManageProjects,
        UsersMutator, UserStaticFunctions,
        Sluggable, SluggableScopeHelpers, UserSluggable,
        CanComment;
}