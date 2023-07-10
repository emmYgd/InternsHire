<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            
            $table->id();
            
            //generate unique id for jobs:
            $table->string('jobs_id');
            //posted by employer with the employer_id:
            $table->string('employer_id')->nullable();

            //or posted by the admin with the admin_id:
            $table->string('admin_id')->nullable();

            $table->string('application_id')->nullable();

            $table->string('owner')->nullable()->enum(['employer', 'admin', 'crawled']);

            //job details:
            $table->string('job_title')->nullable();
            $table->string('job_description')->nullable();
            $table->string('job_requirement')->nullable();
            //$table->json('date_posted');//day, month, year posted.
             $table->string('address')->nullable();//street and area...
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('date_expired')->nullable();//day, month, year expired.
            $table->string('expected_start')->nullable();//day, month, year

            $table->string('internship_period')->nullable(); //e.g. 6 months, 1 year.
            

            $table->string('location_type')->nullable()->enum(['remote', 'on-site']);
            $table->string('nature')->nullable()->enum(['full-time', 'part-time']);

           
            $table->string('currency_of_payment')->nullable();//NGN, USD, EUR
            $table->string('salary_or_incentives')->nullable();//amount, competitive, negotiable

            $table->boolean('is_delayed')->nullable()->default(false);

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
        Schema::dropIfExists('jobs');
    }
}
