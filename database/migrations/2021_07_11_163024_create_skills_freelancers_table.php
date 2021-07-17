<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillsFreelancersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skills_freelancers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('freelancer_id');
            $table->foreign('freelancer_id')->references('id')->on('freelancers')
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
        Schema::dropIfExists('skills_freelancers');
    }
}
