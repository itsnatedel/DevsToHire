<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('employer_id');
            $table->foreignId('job_id');

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('restrict')->onUpdate('cascade');
			
			$table->foreign('employer_id')->references('id')->on('companies')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->foreign('job_id')->references('id')->on('jobs')
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
        Schema::dropIfExists('candidates');
    }
}