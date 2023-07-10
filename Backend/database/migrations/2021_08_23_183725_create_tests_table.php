<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();

            //unique test id:
            $table->string('test_id');
            $table->string('skill_name');
            $table->string('skill_level');
            $table->time('expiry');
            $table->float('score');//this should be converted to percentage in services

            //this json format should be in the form of {question, option{1,2,3,4}, answer}
            $table->json('contents');
            $table->string('badge_name');

            //number of people that have passed this test:
            $table->integer('passed_number');

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
        Schema::dropIfExists('tests');
    }
}
