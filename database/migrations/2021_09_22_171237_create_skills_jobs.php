<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkillsJobs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skills_jobs', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->id();
            $table->string('skills')->nullable();
	
	        $table->foreignId('job_id');
			$table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
	
	        $table->foreignId('employer_id');
	        $table->foreign('employer_id')->references('id')->on('companies')
		        ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skills_jobs');
    }
}