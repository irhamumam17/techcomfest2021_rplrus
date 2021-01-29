<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
          $table->increments('id');
          $table->bigInteger('user_id')->unsigned();
          $table->integer('field_id')->unsigned();
          $table->date('date');
          $table->string('time');
          $table->string('code')->nullable();
          $table->integer('total_price');
          $table->enum('status', ["PENDING", "ACCEPT", "REJECT"])->default("PENDING");
          $table->timestamps();

          $table->foreign('user_id')->references('id')->on('users');
          $table->foreign('field_id')->references('id')->on('fields');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('bookings', function(Blueprint $table){
            $table->dropForeign('bookings_user_id_foreign');
            $table->dropForeign('bookings_field_id_foreign');
        });
        Schema::dropIfExists('bookings');
    }
}
