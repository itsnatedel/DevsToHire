<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
			
            $table->foreignId('category_id');
            $table->foreign('category_id')->references('id')->on('categories')
                ->onDelete('restrict')->onUpdate('cascade');
	
	        $table->foreignId('location_id')->nullable();
	        $table->foreign('location_id')->references('id')->on('locations')
		        ->onDelete('restrict')->onUpdate('cascade');

            $table->string('slug', 255);
            $table->boolean('only_locally')->default(0);
			
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