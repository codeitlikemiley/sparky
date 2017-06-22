<?php

namespace App\Traits\StaticFunctions;

trait UserStaticFunctions
{
   public static function findByEmail($email)
    {
        return self::whereEmail($email)->firstOrFail();
    }

    public static function findByUsername($username)
    {
    return self::whereUsername($username)->firstOrFail();
    }
}