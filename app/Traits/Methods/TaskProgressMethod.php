<?php

namespace App\Traits\Methods;

trait TaskProgressMethod
{

    private static function get_percentage($total, $number) : float
    {
        if ( $total > 0 ) {
            return round($number / ($total / 100),2);
        } else {
            return 0;
        }
    }

    public static function progress($modelOrID) : int
    {
        $task = self::normalize($modelOrID);
        return round(self::get_percentage(self::total($task), self::done($task)));
    }

    public static function total($modelOrID) : int
    {
        $task = self::normalize($modelOrID);
        return $task->subtasks()->sum('assigned_points');
    }

    public static function done($modelOrID) : int
    {
        $task = self::normalize($modelOrID);
        return $task->subtasks()->where('done',true)->sum('assigned_points');
    }
}