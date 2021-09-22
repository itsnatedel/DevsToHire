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
            $table->id();
            $table->string('skills')->nullable();
	
	        $table->foreignId('job_id');
			$table->foreign('job_id')->references('id')->on('jobs')
				->onUpdate('cascade');
	
	        $table->foreignId('employer_id');
	        $table->foreign('employer_id')->references('id')->on('companies')
		        ->onUpdate('cascade');
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