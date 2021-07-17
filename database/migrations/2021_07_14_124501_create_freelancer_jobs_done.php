<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFreelancerJobsDone extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freelancer_jobs_done', function (Blueprint $table) {
            $table->id();
            $table->dateTime('done_at')->default(Carbon::now());
            $table->text('title');
            $table->boolean('on_time')->default(0);
            $table->boolean('recommended')->default(0);
            $table->boolean('on_budget')->default(0);
            $table->smallInteger('rating')->default(0);
            $table->longText('comment')->nullable();
            $table->boolean('success')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('freelancer_jobs_done');
    }
}
