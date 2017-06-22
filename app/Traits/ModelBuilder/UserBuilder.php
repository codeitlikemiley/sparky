<?php

namespace App\Traits\ModelBuilder;

use App\Traits\Relationship\HasClients;
use App\Traits\Relationship\HasEmployees;
use App\Traits\Relationship\HasProjects;
use App\Traits\Relationship\CanManageClients;
use App\Traits\Relationship\CanManageEmployees;
use App\Traits\Relationship\CanManageProjects;
use App\Traits\Mutators\UsersMutator;
use App\Traits\Methods\UsersMethod;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use App\Traits\Sluggable\UserSluggable;
use App\Traits\Relationship\HasComments;

trait UserBuilder {
    use HasClients, HasEmployees, HasProjects,
        CanManageClients, CanManageEmployees, CanManageProjects,
        UsersMutator, UsersMethod,
        Sluggable, SluggableScopeHelpers, UserSluggable,
        HasComments;
}