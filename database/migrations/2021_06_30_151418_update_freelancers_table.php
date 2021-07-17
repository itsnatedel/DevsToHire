<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFreelancersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('freelancers', function (Blueprint $table) {
            $table->foreignId('location_id');
            $table->foreign('location_id')->references('id')->on('locations')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->foreignId('category_id');
            $table->foreign('category_id')->references('id')->on('categories')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->dateTime('joined_at');
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
