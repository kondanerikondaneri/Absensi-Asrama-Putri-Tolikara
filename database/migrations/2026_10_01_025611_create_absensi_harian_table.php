<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiHarianTable extends Migration
{
    public function up()
    {
        Schema::create('absensi_harian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('metode', ['gps', 'qr_code', 'manual']);
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->decimal('jarak_meter', 8, 2)->nullable();
            $table->string('qr_code_value', 255)->nullable();
            $table->enum('status', ['berhasil', 'gagal', 'di_luar_radius']);
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('waktu_absensi')->useCurrent();
            $table->timestamps();
            
            $table->index(['user_id', 'waktu_absensi']);
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('absensi_harian');
    }
}
