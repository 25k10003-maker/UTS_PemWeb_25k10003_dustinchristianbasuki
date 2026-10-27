<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('t003_users', function (Blueprint $table) {
            if (!Schema::hasColumn('t003_users', 'username')) {
                $table->string('username', 100)->nullable()->unique()->after('name');
            }
            if (!Schema::hasColumn('t003_users', 'nim')) {
                $table->string('nim', 50)->nullable()->index()->after('username');
            }
            if (!Schema::hasColumn('t003_users', 'avatar')) {
                $table->string('avatar', 255)->nullable()->default('uploads/profile_dustin.png')->after('role');
            }
        });

        Schema::table('t003_mahasiswa', function (Blueprint $table) {
            if (!Schema::hasColumn('t003_mahasiswa', 'foto')) {
                $table->string('foto', 255)->nullable()->default('uploads/profile_dustin.png')->after('email');
            }
        });
    }

    public function down(): void
    {
        Schema::table('t003_users', function (Blueprint $table) {
            $table->dropColumn(['username', 'nim', 'avatar']);
        });

        Schema::table('t003_mahasiswa', function (Blueprint $table) {
            $table->dropColumn(['foto']);
        });
    }
};
