<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles', 'id');
            $table->string('firstName');
            $table->string('lastName');
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('userImage');
            $table->enum('status', ['0', '1']);
            $table->string('activationCode');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('users');
    }
};
