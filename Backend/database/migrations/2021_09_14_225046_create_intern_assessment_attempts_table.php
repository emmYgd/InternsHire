<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternAssessmentAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intern_assessment_attempts', function (Blueprint $table) {
            $table->id();

            $table->string('assessment_id');//to assure the relationship
            $table->string('intern_id');//interns that attempted this questions..

            $table->string('question')->nullable();//questions 
            $table->json('options')->nullable();//e.g: {'a':'Goat', 'b': 'Ram'}
            $table->string('answer')->nullable();//one correct options

            $table->integer('attempt_times');//number of attempts..
            $table->integer('test_score');
            $table->float('percentage_score');//(test_score/all_test_number) * 100 % set in model..

            $table->boolean('has_passed')->nullable()->default(false);
        
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
        Schema::dropIfExists('intern_assessment_attempts');
    }
}
