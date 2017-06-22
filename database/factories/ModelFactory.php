<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = 'secret',
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Project::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});

$factory->define(App\Campaign::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->catchPhrase(),
    ];
});

$factory->define(App\Task::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->catchPhrase(),
        'description' => $faker->sentence($nbWords = 15, $variableNbWords = true),
        'link' => $faker->url(),
        'max_points' => $faker->numberBetween($min = 50, $max = 100),
    ];
});


$factory->define(App\SubTask::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->catchPhrase(),
        'assigned_points' => $faker->numberBetween($min = 1, $max = 10),
        'priority' => $faker->numberBetween($min = 1, $max = 5),
        'video_link' => $faker->url(),
        'due_date' => \Carbon\Carbon::now()->addDays(10)->toDateTimeString(),
    ];
});

