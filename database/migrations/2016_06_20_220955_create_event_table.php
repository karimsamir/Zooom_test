<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('event', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')
                    ->references('id')->on('country')
                    ->onDelete('cascade');
            
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')
                    ->references('id')->on('category')
                    ->onDelete('cascade');

            $table->string('title', 100);
            $table->string('location');
            $table->float('longitude');
            $table->float('latitude');
            $table->string('zip', 15);
            $table->text('description');
            $table->timestamp('startdate');
            $table->timestamp('enddate');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('event');
    }

}