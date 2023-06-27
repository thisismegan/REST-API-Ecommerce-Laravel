<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products', 'id');
            $table->string('imageName');
        });
    }


    public function down()
    {
        Schema::dropIfExists('images');
    }
};
