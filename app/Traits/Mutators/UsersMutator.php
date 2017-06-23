<?php

namespace App\Traits\Mutators;

trait UsersMutator
{
   public function setEmailAttribute($email)
    {
        // Ensure valid email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("Invalid email address.");
        }

        // Ensure email does not exist
        elseif (static::whereEmail($email)->count() > 0) {
            throw new \Exception("Email already exists.");
        }

        $this->attributes['email'] = $email;
    }
    
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    public function getPhotoUrlAttribute($value)
    {
        return empty($value) ? 'https://www.gravatar.com/avatar/'.md5(Str::lower($this->email)).'.jpg?s=200&d=mm' : url($value);
    }
}