<?php

namespace App\Traits\ModelBuilder;

use App\Traits\MorphTo\Uploadable;
use App\Traits\Relationship\byTenant;

trait FileBuilder {
    use Uploadable, byTenant;
}