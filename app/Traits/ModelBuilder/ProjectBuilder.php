<?php

namespace App\Traits\ModelBuilder;

use App\Traits\Permissions\OwnsByTenant;
use App\Traits\Permissions\OwnsByClient;
use App\Traits\Permissions\AllowedEmployees;
use App\Traits\MorphTo\Projectable;
use App\Traits\Sluggable\ProjectSluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

trait ProjectBuilder {
    use OwnsByTenant, OwnsByClient, AllowedEmployees, Projectable,
        ProjectSluggable, SluggableScopeHelpers;
}