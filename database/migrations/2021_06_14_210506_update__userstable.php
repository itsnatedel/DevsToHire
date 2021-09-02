<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserstable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('can_be_rated')->default(0);

            $table->string('dir_url', 150)->nullable();

            $table->foreignId('role_id')->default(2);
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->foreignId('location_id')->default(200);
            $table->foreign('location_id')->references('id')->on('locations')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->foreignId('freelancer_id')->nullable()->default(null);
            $table->foreign('freelancer_id')->references('id')->on('freelancers')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->foreignId('company_id')->nullable()->default(null);
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
        Schema::dropIfExists('users');
    }
}
