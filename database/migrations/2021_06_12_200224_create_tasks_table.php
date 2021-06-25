<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->longText('description');
            $table->integer('budget_min')->default(10);
            $table->integer('budget_max')->default(2500);
            $table->enum('type', [
                'Fixed',
                'Hourly'
            ])->default('Fixed');
            $table->date('due_date');
            $table->timestamp('created_at')->default(now());
            $table->foreignId('employer_id');

            $table->foreign('employer_id')->references('id')->on('companies')
                ->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
