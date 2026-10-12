<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurfewChecksTable extends Migration
{
    public function up()
    {
        Schema::create('curfew_checks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('checked_by')->constrained('users')->cascadeOnDelete();
            $table->enum('metode', ['manual', 'qr_code']);
            $table->boolean('is_hadir');
            $table->text('catatan')->nullable();
            $table->date('tanggal_cek');
            $table->timestamp('waktu_cek')->useCurrent();
            $table->timestamps();
            
            $table->unique(['user_id', 'tanggal_cek']);
            $table->index('checked_by');
        });
    }

    public function down()
    {
        Schema::dropIfExists('curfew_checks');
    }
}
