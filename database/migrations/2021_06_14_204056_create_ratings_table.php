<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->id();
            $table->timestamps();
            $table->foreignId('voter_id');
            $table->foreignId('rated_user');

            $table->tinyInteger('note');

            $table->foreign('voter_id')->references('id')->on('users')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('rated_user')->references('id')->on('users')
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
        Schema::dropIfExists('ratings');
    }
}