<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKamarTable extends Migration
{
    public function up()
    {
        Schema::create('kamar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blok_asrama_id')->constrained('blok_asrama')->cascadeOnDelete();
            $table->string('nomor_kamar', 20);
            $table->integer('kapasitas')->default(4);
            $table->timestamps();
            
            $table->unique(['blok_asrama_id', 'nomor_kamar']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('kamar');
    }
}
