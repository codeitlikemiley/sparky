<?php

namespace App\Traits\Clients;

use App\Traits\Mutators\UsersMutator;
use App\Traits\StaticFunctions\UserStaticFunctions;

trait ClientBuilder {
    use UsersMutator, UserStaticFunctions;
}