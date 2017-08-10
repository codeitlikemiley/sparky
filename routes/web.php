<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', 'WelcomeController@show')->name('frontend');

Route::group(['prefix' => '/dashboard'], function () {
      Route::get('/', 'HomeController@show')->name('dashboard');
      Route::post('/projects/create', 'Project\CreateProject')->name('tenant.projects.create');
      Route::post('/projects/{projectID}/edit', 'Project\EditProject')->name('tenant.projects.edit');
      Route::post('/projects/{projectID}/delete', 'Project\DeleteProject')->name('tenant.projects.delete');
      Route::post('/projects/{projectID}/campaigns/create', 'Campaign\CreateCampaign')->name('tenant.campaigns.create');
      Route::post('/campaigns/{campaign}/edit', 'Campaign\EditCampaign')->name('tenant.campaigns.edit');
      Route::post('/campaigns/{campaign}/reorder', 'Campaign\ReOrderCampaign')->name('tenant.campaigns.reorder');
      Route::post('/campaigns/{campaign}/delete', 'Campaign\DeleteCampaign')->name('tenant.campaigns.delete');
      Route::get('/projects/{projectID}', 'Project\ShowProject')->name('tenant.projects.view');
      Route::post('/projects/{projectID}/progress', 'Project\CampaignsProgress')->name('tenant.projects.progress');
      Route::get('/tasks/{task}', 'Task\ShowTask')->name('tenant.tasks.view');
      Route::post('/campaigns/{campaign}/tasks/create', 'Task\CreateTask')->name('tenant.tasks.create');
      Route::put('/tasks/{task}/edit', 'Task\EditTask')->name('tenant.tasks.edit');
      Route::delete('/tasks/{task}/delete', 'Task\DeleteTask')->name('tenant.tasks.delete');

      Route::put('/ratings/{subtask}','Subtask\UpdateRatings')->name('tenant.subtasks.ratings');
      Route::get('/tasks/{task}/subtasks', 'Subtask\ShowSubtask')->name('tenant.subtasks.index');
      Route::put('/tasks/{task}/subtasks/{subtask}/toggle', 'Subtask\ToggleSubtask')->name('tenant.subtasks.toggle');
      Route::delete('/tasks/{task}/subtasks/{subtask}/delete', 'Subtask\DeleteSubtask')->name('tenant.subtasks.delete');
    //   Route::post('/tasks/{task}/subtasks/create', 'Subtask\CreateSubtask')->name('tenant.subtasks.create');
    //   Route::put('/tasks/{task}/subtasks/{subtask}/edit', 'Subtask\EditSubtask')->name('tenant.subtasks.edit');
    //   Route::delete('/tasks/{task}/subtasks/{subtask}/delete', 'Subtask\DeleteSubtask')->name('tenant.subtasks.delete');
  });

  Route::group(['prefix' => '/users'], function () {
      Route::get('/employee', 'User\ShowEmployee')->name('tenant.employees.index');
      Route::get('/client', 'User\ShowClient')->name('tenant.clients.index');
  });
Route::get('/files', 'File\Index')->name('tenant.files.index');
Route::post('/files/upload/{projectID}', 'File\UploadController@multiple_upload')->name('tenant.file.uploader');
Route::put('/files/edit/{fileID}', 'File\EditFile')->name('tenant.file.edit');
Route::put('/files/delete/{fileID}', 'File\DeleteFile')->name('tenant.file.delete');
Route::get('/files/show/{projectID}', 'File\ShowProjectFiles')->name('tenant.files.show');

