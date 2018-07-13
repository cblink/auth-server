<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthServerTable extends Migration
{

    public function up()
    {
        Schema::create(config('auth_server.table'), function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger(config('auth_server.foreign_id'))->index()->nullable();
            $table->string('name')->comment('auth app name');
            $table->string('app_id')->unique();
            $table->string('secret');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(config('auth_server.table'));
    }
}