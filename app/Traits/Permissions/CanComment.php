<?php 

namespace App\Traits\Permissions;

use BrianFaust\Commentable\Comment;

trait CanComment
{
    // This Trait Needs to Be Added to User, Employee and Clients
    // Since a User, Employee, Client Can Comment
    public function comments()
    {
        return $this->morphMany(Comment::class, 'creator');
    }
}