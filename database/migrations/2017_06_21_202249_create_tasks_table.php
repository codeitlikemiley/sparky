<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_id')->unsigned();
            $table->foreign('campaign_id')
                  ->references('id')->on('campaigns')
                  ->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('link')->nullable();
            $table->integer('max_points')->default(1);
            $table->boolean('done')->default(0);
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
        Schema::table('tasks', function (Blueprint $table) {
            //
        });
    }
}
