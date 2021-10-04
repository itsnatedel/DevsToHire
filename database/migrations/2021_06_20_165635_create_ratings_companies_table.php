<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    class CreateRatingsCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings_companies', function (Blueprint $table) {
            $table->id();
            $table->enum('note', [
                1,
                2,
                3,
                4,
                5])->default(1);
            $table->longText('comment')->nullable();
            $table->timestamp('when')->default(now());
            $table->string('reviewTitle', 255);
            $table->string('freelancer_name', 255);
            
            $table->foreignId('freelancer_id');
            $table->foreign('freelancer_id')->references('id')->on('freelancers')->constraigned();

            $table->foreignId('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->constraigned();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings_companies');
    }
}