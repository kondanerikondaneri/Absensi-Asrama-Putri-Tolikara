<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kamar_id')->nullable()->constrained('kamar')->nullOnDelete(); 
            $table->string('nama_lengkap', 255);
            $table->string('nomor_identitas', 50)->unique();
            $table->string('username', 100)->unique();
            $table->string('password', 255);
            $table->enum('role', ['penghuni', 'keamanan', 'pengurus']);
            $table->enum('status', ['di_asrama', 'sedang_di_luar'])->default('di_asrama');
            $table->string('no_telepon', 20)->nullable();
            $table->string('foto', 255)->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('role');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
