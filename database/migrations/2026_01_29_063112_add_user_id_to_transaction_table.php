<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('user_id')
                  ->nullable()
                  ->after('transaction_id')
                  ->constrained('users')
                  ->onDelete('cascade');
        });

        // ✅ Use DB::table instead of Model to avoid SoftDeletes
        \DB::table('transactions')
            ->whereNull('user_id')
            ->update(['user_id' => 1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign('user_id');
            $table->dropColumn('user_id');
        });
    }
};
