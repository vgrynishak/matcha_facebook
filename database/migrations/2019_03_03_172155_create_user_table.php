<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('lastname');
            $table->string('email');
            $table->string('pas');
            $table->integer('activate')->default('0');
            $table->string('url_activate')->default('NULL');
//            $table->timestamps();
            $table->timestamp('created_at')->useCurrent();
//            $table->timestamp('updated_at')->default('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
