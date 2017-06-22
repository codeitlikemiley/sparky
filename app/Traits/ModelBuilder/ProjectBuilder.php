<?php

namespace App\Traits\ModelBuilder;

use App\Traits\Permissions\OwnsByTenant;
use App\Traits\MorphTo\Projectable;
use App\Traits\Sluggable\ProjectSluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

trait ProjectBuilder {
    use OwnsByTenant, Projectable, ProjectSluggable, SluggableScopeHelpers;
}