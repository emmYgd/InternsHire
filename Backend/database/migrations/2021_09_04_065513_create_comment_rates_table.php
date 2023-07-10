<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_rates', function (Blueprint $table) {
            $table->id();

            $table->string('comment_rate_id');
            $table->string('owner')->enum(['intern', 'employer', 'admin']);

            $table->string('comment')->nullable();
            $table->float('rating')->nullable();

            //intern can post, rate and can be posted about and rated by employers: 
            $table->string('interns_id')->unique()->nullable();

            //employers can post, rate and can be posted about and rated by interns:
            $table->string('employer_id')->unique()->nullable();

            //admin can post, rate both interns and employers:
             $table->string('admin_id')->unique()->nullable();

            $table->boolean('is_approved_by_admin')->nullable()->default(false);


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
        Schema::dropIfExists('comment_rates');
    }
}
