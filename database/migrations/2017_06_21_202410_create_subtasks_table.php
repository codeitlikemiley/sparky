<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubtasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subtasks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('task_id');
            $table->foreign('task_id')
                  ->references('id')->on('tasks')
                  ->onDelete('cascade');
            $table->string('name');
            $table->string('assigned_points')->default(1);
            $table->enum('priority', ['1', '2','3','4','5'])->default(1);
            $table->string('video_link')->nullable();
            $table->boolean('done')->default('0');
            $table->timestamp('due_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('subtasks');
    }
}
