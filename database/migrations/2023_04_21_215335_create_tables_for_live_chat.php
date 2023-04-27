<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesForLiveChat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('chat_participants', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('chatId')->unsigned();
            $table->foreign('chatId')
                ->references('id')
                ->on('chats')
                ->onDelete('cascade');

            $table->integer('userId')->unsigned();
            $table->foreign('userId')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::create('chat_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->text('message');
            $table->string('type')->default('text');
            $table->string('read', 1)->default('N');

            $table->integer('chatParticipantId')->unsigned()->nullable();
            $table->foreign('chatParticipantId')
                ->references('id')
                ->on('chat_participants')
                ->onDelete('set null');

            $table->integer('chatId')->unsigned();
            $table->foreign('chatId')
                ->references('id')
                ->on('chats')
                ->onDelete('cascade');
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
        Schema::dropIfExists('chat_participants');
        Schema::dropIfExists('chat_messages');
    }
}
