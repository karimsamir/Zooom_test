<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_user', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('event_id')->unsigned();
            $table->foreign('event_id')
                    ->references('id')->on('event')
                    ->onDelete('cascade');
            
            $table->integer('users_id')->unsigned();
            $table->foreign('users_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');
            
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
        Schema::drop('event_user');
    }
}
