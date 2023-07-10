<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();

            //admin unique id:
            $table->string('admin_id')->unique();
            //$table->string('admin_chat_id')->unique();

            $table->boolean('is_logged_in')->default(false)->nullable();

            $table->string('email');
            $table->string('name');
            $table->string('password');

            //admin optional details:
            $table->string('admin_org')->nullable();
            $table->string('vision')->nullable();
            $table->string('mission')->nullable();
            $table->integer('year_of_establishment')->nullable();
            $table->binary('logo')->nullable();

            //admin can comment and rate users(employer or intern) - the formats will be: user_unique_id, comment, rating
            //$table->string('comments_rate_id ');

            //a list of all the unique ids of all the job posts so far by this admin 
            //$table->json('job_posts')->nullable();

            //a list of jobs that this admin has applied to:
            //$table->json('job_applied')->nullable();

            //a list of unique ids of all tests set by this admin, linkable to the assessment table:
            //$table->json('assessment_id')->nullable();

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
        Schema::dropIfExists('admins');
    }
}
