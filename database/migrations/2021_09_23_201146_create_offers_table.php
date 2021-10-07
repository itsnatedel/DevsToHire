<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->id();
            $table->timestamp('created_at')->default(now());
			$table->text('message');
			$table->string('file_url');
			$table->string('offeror_name');
			$table->string('offeror_email');
			
			$table->foreignId('freelancer_id');
			$table->foreign('freelancer_id')->references('id')->on('freelancers');
			
			$table->foreignId('user_id');
			$table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}