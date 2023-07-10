<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {

            $table->id();

            $table->string('chat_id')->unique();

            $table->string('chat_type');/*(1)intern/employer(2)Intern/Admin(3)Employer/Admin*/
 
            $table->date('chat_date')->unique();
            $table->time('chat_time_start')->unique();
            $table->time('chat_time_end')->unique();
            $table->boolean('is_chat_allowed')->default(true);//can only be modified by the Admin..
            $table->string('control_chats')->unique();

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
        Schema::dropIfExists('chats');
    }

}
