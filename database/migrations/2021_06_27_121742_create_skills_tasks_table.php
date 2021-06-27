<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillsTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skills_tasks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('task_id');
            $table->foreign('task_id')->references('id')->on('tasks')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->string('skills', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skills_tasks');
    }
}
