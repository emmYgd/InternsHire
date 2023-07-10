<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();

            $table->string('admin_id')->nullable();

            //$table->string('assessment_id');
            $table->string('test_skill_name')->nullable(); //the skill to test the intern for...
            $table->time('duration')->nullable(); //e.g 50 seconds. //check out php date time
            $table->string('instructions')->nullable();
            $table->string('hints')->nullable();
            
            $table->integer('max_attempt_times');//interns cannot take the test when it is more than this...not compulsory to set this on every count

            $table->float('pass_mark')->nullable()->default(50.00); //percentage for pass...below this means failure

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
        Schema::dropIfExists('assessments');
    }
}
