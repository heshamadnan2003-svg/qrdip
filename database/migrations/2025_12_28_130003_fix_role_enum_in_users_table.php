<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // تعديل القيم الموجودة
        DB::table('users')
            ->where('role', 'organization')
            ->update(['role' => 'manager']);

        // إعادة تعريف enum
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'manager', 'user'])
                  ->default('user')
                  ->change();
        });
    }

    public function down(): void
    {
        DB::table('users')
            ->where('role', 'manager')
            ->update(['role' => 'organization']);

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'organization', 'user'])
                  ->default('user')
                  ->change();
        });
    }
};
