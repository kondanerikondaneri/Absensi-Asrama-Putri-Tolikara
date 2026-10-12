<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQrCodesTable extends Migration
{
    public function up()
    {
        Schema::create('qr_codes', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 255)->unique();
            $table->enum('tipe', ['lokasi', 'kamar', 'identitas']);
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->string('reference_type', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['tipe', 'is_active']);
            $table->index(['reference_id', 'reference_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('qr_codes');
    }
}
