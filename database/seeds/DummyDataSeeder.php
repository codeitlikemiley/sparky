<?php

use Illuminate\Database\Seeder;
use  Illuminate\Support\Facades\DB as DB;
use Faker\Factory as Faker;
use App\Employee;
use App\Project;
use App\Campaign;
use App\Task;
use App\Subtask;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    $faker = Faker::create();
    factory(Employee::class, 1)->create()->each(function ($e) {
         $e->projects()->saveMany(factory(Project::class, 2)->create());
     });
    $projects = Project::all()->pluck('id')->toArray();
    $employees = Employee::all()->pluck('id')->toArray();

    factory(Campaign::class, 5)->create()->each(function ($e) use ($faker, $projects, $employees) {
        auth()->guard('employee')->loginUsingId($faker->randomElement($employees));
        $p = $faker->randomElement($projects);
        $p =  Project::find($p);
         $e->project()->associate($p);
         $e->save();
         $e->tasks()->saveMany(factory(Task::class, 10)->create());
         auth()->guard('employee')->logout();
     });
     $tasks = Task::all()->pluck('id')->toArray();
     factory(Subtask::class,100)->create()->each(function($e) use ($faker,$tasks){
         $p = $faker->randomElement($tasks);
         $p =  Task::find($p);
         $e->task()->associate($p);
         $e->save();
     });
    
    }
}
