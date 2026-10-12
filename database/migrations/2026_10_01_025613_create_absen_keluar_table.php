<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsenKeluarTable extends Migration
{
    public function up()
    {
        Schema::create('absen_keluar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('keterangan')->nullable();
            $table->timestamp('waktu_keluar')->useCurrent();
            $table->timestamp('waktu_kembali')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'waktu_keluar']);
            $table->index('waktu_kembali');
        });
    }

    public function down()
    {
        Schema::dropIfExists('absen_keluar');
    }
}
