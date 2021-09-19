<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFreelancersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freelancers', function (Blueprint $table) {
            $table->id();
            $table->string('firstname', 90);
            $table->string('lastname', 90);
            $table->longText('description')->nullable();
            $table->string('pic_url', 255)->nullable();
            $table->integer('hourly_rate');
            $table->boolean('verified')->default(0);
            $table->string('CV_url')->nullable();
            $table->integer('success_rate')->nullable(); // TODO : Remove this. Use freelancers_jobs_done rating/note data
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('freelancers');
    }
}
