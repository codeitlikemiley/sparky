<?php

namespace App\Traits\Employees;

use App\Traits\Permissions\CanCreateClients;
use App\Traits\Permissions\CanCreateProjects;
use App\Traits\Permissions\CanCreateEmployees;
use App\Traits\Permissions\CanManageClients;
use App\Traits\Permissions\CanManageProjects;
use App\Traits\Permissions\CanManageEmployees;


trait EmployeeBuilder {
    use CanCreateClients, CanCreateEmployees, CanCreateProjects,
        CanManageClients, CanManageEmployees, CanManageProjects;
}