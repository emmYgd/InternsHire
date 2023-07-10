<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelegateRecruitmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delegate_recruitments', function (Blueprint $table) {
            $table->id();

            //for employer delegating recruitments of interns to us:
            //$table->string('delegate_recruit_id');
            $table->string('employer_id');

             //Employer wishing to delegate recruitment to us must pay:
            $table->string('payment_id');
            //this can be looked up in the payment table.

            $table->string('recruitment_type')->enum(['online_test', 'full_test']);//in the online test, interns are accessed online alone; but in the full test, the aim is to evaluate both for the online test and the person calling and verification test by in-house team...

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
        Schema::dropIfExists('delegate_recruitments');
    }
}
