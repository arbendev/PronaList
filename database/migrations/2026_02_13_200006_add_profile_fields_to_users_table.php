<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('avatar')->nullable()->after('phone');
            $table->text('bio')->nullable()->after('avatar');
            $table->enum('role', ['user', 'agent', 'admin'])->default('user')->after('bio');
            $table->string('agency_name')->nullable()->after('role');
            $table->string('license_number')->nullable()->after('agency_name');
            $table->boolean('is_verified')->default(false)->after('license_number');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'avatar', 'bio', 'role', 'agency_name', 'license_number', 'is_verified']);
        });
    }
};
