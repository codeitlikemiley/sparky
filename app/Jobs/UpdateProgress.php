<?php

namespace App\Jobs;

use DB;
use Log;
use App\Task;
use Exception;
use App\Subtask;
use App\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class UpdateProgress implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $subtask;

    /**
     * Create a new job instance.
     *
     * @param  Podcast  $podcast
     * @return void
     */
    public function __construct(Subtask $subtask)
    {
        $this->subtask = $subtask;
    }

    
    public function handle()
    {
        $task = $this->subtask->task;
        if (!$task) {
            throw new Exception('Processing Task Points Failed with Subtask ID of: ' . $this->subtask->id);
        }
        $task->total_points = $task->total;
        $task->done_points = $task->done ;
        $task->save();

        $campaign = $task->campaign;
        if (!$campaign) {
            throw new Exception('Processing Campaign Points Failed with Subtask ID of: ' . $this->subtask->id);
        }
        $campaign->total_points = $campaign->total;
        $campaign->done_points = $campaign->done;
        $campaign->save();
        
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $e)
    {
        Log::error($e->getMessage());
    }
}