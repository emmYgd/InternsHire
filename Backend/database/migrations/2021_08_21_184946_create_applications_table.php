<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            $table->string('application_id')->unique();
            $table->string('job_id')->unique();

            $table->string('intern_id')->unique();
            $table->string('available_interview_dates')->nullable();
            $table->string('available_interview_times')->nullable();
            //$table->boolean('have_applied')->default(false)->nullable();
            $table->boolean('is_delayed')->default(false)->nullable();

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
        Schema::dropIfExists('applications');
    }
}
