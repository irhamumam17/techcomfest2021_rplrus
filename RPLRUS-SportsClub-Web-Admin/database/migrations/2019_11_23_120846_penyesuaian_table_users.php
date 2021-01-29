<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PenyesuaianTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('users', function (Blueprint $table) {
          $table->string("username")->unique();
          $table->string("roles");
          $table->string("phone");
          $table->text("address");
          $table->string("avatar")->nullable();
          $table->string("token")->nullable();
          $table->enum("status", ["ACTIVE", "INACTIVE"])->default("ACTIVE");
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('users', function (Blueprint $table) {
          $table->dropColumn("username");
          $table->dropColumn("roles");
          $table->dropColumn("address");
          $table->dropColumn("phone");
          $table->dropColumn("avatar");
          $table->dropColumn("status");
          $table->dropColumn("token");
      });
    }
}
