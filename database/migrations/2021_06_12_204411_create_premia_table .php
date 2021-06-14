<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePremiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('premium', function (Blueprint $table) {
            $table->id();
            $table->string('plan', 20);
            $table->text('description');
            $table->integer('monthly_price');
            $table->integer('yearly_price');
            $table->string('listing');
            $table->string('visibility_days');
            $table->string('highlighted')->default('Highlighted in Search Results');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('premium');
    }
}
