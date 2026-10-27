<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t003_matakuliah', function (Blueprint $table) {
            $table->id();
            $table->string('kode_mk', 20)->unique();
            $table->string('nama_mk', 100);
            $table->integer('sks')->default(3);
            $table->integer('semester')->default(1);
            $table->timestamps();
        });

        Schema::create('t003_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('t003_users')->nullOnDelete();
            $table->string('nim', 30)->unique();
            $table->string('nama', 100);
            $table->integer('angkatan')->default(2025);
            $table->string('email', 100)->unique();
            $table->timestamps();
        });

        Schema::create('t003_nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('t003_mahasiswa')->cascadeOnDelete();
            $table->foreignId('matakuliah_id')->constrained('t003_matakuliah')->cascadeOnDelete();
            $table->decimal('nilai_angka', 5, 2);
            $table->string('nilai_huruf', 5);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t003_nilai');
        Schema::dropIfExists('t003_mahasiswa');
        Schema::dropIfExists('t003_matakuliah');
    }
};
