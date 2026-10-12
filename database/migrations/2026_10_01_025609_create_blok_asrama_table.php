<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlokAsramaTable extends Migration
{
    public function up()
    {
        Schema::create('blok_asrama', function (Blueprint $table) {
            $table->id();
            $table->string('nama_blok', 100);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('blok_asrama');
    }
}
