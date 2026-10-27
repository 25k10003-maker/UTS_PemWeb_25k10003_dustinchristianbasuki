<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('t003_users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'dosen', 'mahasiswa', 'operator'])->default('mahasiswa')->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('t003_users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
