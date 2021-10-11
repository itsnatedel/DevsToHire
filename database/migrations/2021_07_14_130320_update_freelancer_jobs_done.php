<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFreelancerJobsDone extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('freelancer_jobs_done', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->foreignId('job_id');
            $table->foreign('job_id')->references('id')->on('jobs')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreignId('freelancer_id');
            $table->foreign('freelancer_id')->references('id')->on('freelancers')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreignId('employer_id');
            $table->foreign('employer_id')->references('id')->on('companies')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}