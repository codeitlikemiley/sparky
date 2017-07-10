<?php

namespace App\Observers;

use App\Subtask;
use App\Jobs\UpdateProgress;
use App\Jobs\DecreasePoints;
use App\Jobs\IncreasePoints;
use Log;

class SubtaskObserver
{
    /**
     * Listen to the Subtask created event.
     *
     * @param  Subtask  $subtask
     * @return void
     */
    public function created(Subtask $subtask)
    {
        $job = (new IncreasePoints($subtask))->onQueue('add_points');
        dispatch($job);
    }

    /**
     * This Should Only Be Trigger When We Changed Points
     *
     * @param  Subtask  $subtask
     * @return void
     */
    public function saved(Subtask $subtask)
    {
        $this->updatePoints(['points','done'],$subtask);
    }
    
    
    private function updatePoints($array, $subtask)
    {
        
        $changes = $this->setDefaultFor($array,$subtask);
        
        $task = $this->hasTask($subtask);
        
        $campaign = $this->hasCampaign($subtask);
        
        $diff = abs($changes['points']['old'] - $changes['points']['new']);
        

        // done point increased
        // from false to true
        if($changes['done']['old'] == false && $changes['done']['new'] == true){
            $task->done_points = $task->done_points + $diff;
            $campaign->done_points = $campaign->done_points + $diff;
        }
        // done point decreased
        // from true to false
        if($changes['done']['old'] == true && $changes['done']['new'] == false){
            $task->done_points = $task->done_points - $diff;
            $campaign->done_points = $campaign->done_points - $diff;
        }

        // both are true...
        if($changes['done']['old'] == true && changes['done']['new'] == true)
        {
            // total done point increased
            if($changes['points']['old'] < $changes['points']['new']){
                $task->done_points = $task->done_points + $diff;
                $campaign->done_points = $campaign->done_points + $diff;
            }
            // total done point decreased
            if($changes['points']['old'] > $changes['points']['new']){
                $task->done_points = $task->done_points - $diff;
                $campaign->done_points = $campaign->done_points -$diff;
            }

        }
        // total points increased
        if($changes['points']['old'] < $changes['points']['new']){
                $task->total_points = $task->total_points + $diff;
                $campaign->total_points = $campaign->total_points + $diff;
            }
        // total points decreased
        if($changes['points']['old'] > $changes['points']['new']){
                $task->total_points = $task->total_points - $diff;
                $campaign->total_points = $campaign->total_points - $diff;
        }

        $task->save();
        $campaign->save();
    }

    // we need the deleting...
    public function deleting(Subtask $subtask)
    {
        $job = (new DecreasePoints($subtask))->onQueue('decrease_points');
        dispatch($job);
    }

    

    private function hasTask(Subtask $subtask)
    {
        if($task = $subtask->task ?? false)
        {
            return $task;
        }
        throw new Exception('Updating Task Points Failed with Subtask ID of: ' . $subtask->id);
    }

    private function hasCampaign(Subtask $subtask)
    {
        if($task =$subtask->task->campaign ?? false)
        {
            return $task;
        }
        throw new Exception('Updating Task Points Failed with Subtask ID of: ' . $subtask->id);
    }

    private function setDefaultFor($array,$subtask)
    {
        $changes = $this->getChanges($array,$subtask) ?? array();
        foreach ($array as $key) {
            $original = $subtask->getOriginal($key);
            if(!array_key_exists($key, $changes))
            {
            $changes[$key] = [
                    'old' => $original,
                    'new' => $original,
                ];
            }
        }
        
        return $changes;
    }

    private function getChanges($array, Subtask $subtask)
    {

        $changes = $subtask->isDirty() ? $changes = $subtask->getDirty() : array();

        if($changes)
        {
            $changes = array_intersect_key($changes, array_flip($array));
            foreach($changes as $key => $value){
            $original = $subtask->getOriginal($key);
            $changes[$key] = [
                'old' => $original,
                'new' => $value,
            ];
            }
        }
        return $changes;
    }
}