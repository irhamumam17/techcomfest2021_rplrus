<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned();
            $table->integer('field_id')->unsigned();
            $table->string('teamReq');
            $table->string('teamAcc')->nullable();
            $table->date('date');
            $table->enum('status', ["WAITING", "ACCEPT"])->default("WAITING");
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
        Schema::table('matches', function(Blueprint $table){
              $table->dropForeign('matches_user_id_foreign');
              $table->dropForeign('matches_field_id_foreign');
          });

        Schema::dropIfExists('matches');
    }
}
