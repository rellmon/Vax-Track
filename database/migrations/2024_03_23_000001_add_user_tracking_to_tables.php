<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Add created_by_user_id to schedules if it doesn't exist
        if (!Schema::hasColumn('schedules', 'created_by_user_id')) {
            Schema::table('schedules', function (Blueprint $table) {
                $table->foreignId('created_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            });
        }

        // Add user_id to vaccine_records if it doesn't exist
        if (!Schema::hasColumn('vaccine_records', 'user_id')) {
            Schema::table('vaccine_records', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            });
        }
    }

    public function down(): void {
        if (Schema::hasColumn('schedules', 'created_by_user_id')) {
            Schema::table('schedules', function (Blueprint $table) {
                $table->dropForeignIdFor('users', 'created_by_user_id');
                $table->dropColumn('created_by_user_id');
            });
        }

        if (Schema::hasColumn('vaccine_records', 'user_id')) {
            Schema::table('vaccine_records', function (Blueprint $table) {
                $table->dropForeignIdFor('users', 'user_id');
                $table->dropColumn('user_id');
            });
        }
    }
};
