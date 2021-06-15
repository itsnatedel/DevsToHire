<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title', 255);
            $table->longText('description');
            $table->integer('salary_low');
            $table->integer('salary_high');
            $table->enum('type', [
                'Full Time',
                'Freelance',
                'Part Time',
                'Internship',
                'Temporary'
            ])->default('Freelance');
            $table->boolean('featured')->default(0);

            $table->foreignId('company_id');

            $table->foreign('company_id')->references('id')->on('companies')
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
        Schema::dropIfExists('jobs');
    }
}
