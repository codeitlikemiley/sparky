<?php

namespace App\Traits\Methods;

trait LoggersMethod
{
    public function getDescriptionForEvent(string $eventName): string
    {
        // $this->guard is declared in Your Model (User, Employee, Client) as protected properties
        $name = auth()->guard($this->guard)->user()->name;
        // No user
        if(!$name)return "This model has been {$eventName}";
        // With User
        return "{$eventName} by: {$name}";
    }
}