<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interns', function (Blueprint $table) {
            $table->id();

            //generate unique id for interns:
            $table->string('intern_id')->unique()->nullable();
            $table->string('intern_chat_id')->unique()->nullable();

            $table->boolean('is_logged_in')->default(false);

            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password')->unique()->nullable();

            $table->string('firstname');
            $table->string('lastname');

            $table->binary('resume')->nullable();
            $table->binary('picture')->nullable();
            $table->longText('cover_letter')->nullable();

            $table->string('institution')->nullable();
            $table->string('course_of_study')->nullable();
            $table->integer('year_or_level')->nullable();
            $table ->float('current_school_grade')->nullable();
            $table ->string('current_location')->nullable();
            $table ->string('preferred_job_locations')->nullable();
            $table->integer('years_of_experience')->nullable();
            $table->string('skillsets')->nullable();//lists of interns skillsets:

            //scanned copy of internship letter:
            $table->binary('internship_letter_img')->nullable();
          
            //list of intern experiences:format - company_name; from(year, month, day); to(year, month, day); job_role; brief_job_role_description; average_salary(optional); reason_for_leaving(optional)
            $table->json('experiences')->nullable();

            /*industry/categories of jobs preferred by the intern: format - 
            industry(first, second); categories(first, second), timeline(3months, 1year), salary_range*/
            $table->json('job_preferences')->nullable();

            /*jobs applied so far(stored here as Job Application ID which is used to search for jobs that has been applied to on the jobs table).
            format:(first, second)*/
            $table->json('jobs_applied')->nullable();

            /*jobs that has been getting responses so far(stored here as Job Application ID which is used to search for jobs that has been replied to by the employer table).
            format:(first, second)*/
            $table->json('jobs_responses')->nullable();

            //comment and rate users - the formats will be: employer_unique_id, comment, rating
            $table->string('comment_rate_id')->nullable();
 
            //unique payment id for each payment performed by the intern linked to the payment table:
            $table->json('payment_id')->nullable();


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
        Schema::dropIfExists('interns');
    }
}
