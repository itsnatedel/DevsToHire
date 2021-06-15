<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->integer('minimal_rate');
            $table->integer('delivery_time');
            $table->enum('time_period', [
                'Days',
                'Hours',
            ])->default('Days');

            $table->foreignId('bidder_id');
            $table->foreign('bidder_id')->references('id')->on('freelancers')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->foreignId('task_id');
            $table->foreign('task_id')->references('id')->on('tasks')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bids');
    }
}
