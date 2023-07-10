<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employers', function (Blueprint $table) {
            
            $table->id();

            $table->string('employer_id')->nullable()->unique();
            //$table->string('employer_chat_id')->unique();

            $table->boolean('is_logged_in')->default(false)/*->nullable()*/;

            $table->string('email')->unique()/*->nullable()*/;
            $table->string('password')->nullable()->unique();
            $table->string('company_name')->unique()/*->nullable()*/;

            $table->binary('company_logo')->nullable();

            //including: website, facebook, twitter, linkedin, etc
            $table->string('online_presence')/*->nullable()*/; 

            $table->string('current_address')->nullable();
            $table->string('current_location')->nullable();//city/town, state, country
            

            //lists of interns skillsets:
            
            $table->string('industry')/*->nullable()*/;
            $table->string('category')->nullable();//short keywords on what you do...
            $table->string('unit_handling_recruitment')->nullable();//hr, CEO, etc.
            $table->string('brief_details')->nullable();//what the company does, aims and objectives(brief)

            //comment and rate users - the formats will be: user_unique_id, comment, rating
            //$table->string('comments_rate_id');

            //unique payment id for each payment performed by the employer linked to the payment table:
            //$table->json('payment_id');

            //a list of all the unique ids of all the job posts so far by this employer 
            //$table->json('job_posts');

            //delegate recruitment to the admin:
            $table->boolean('is_recruitment_delegated')->default(false)->nullable();

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
        Schema::dropIfExists('employers');
    }
}
