<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Add soft deletes to main tables
        if (Schema::hasTable('children') && !Schema::hasColumn('children', 'deleted_at')) {
            Schema::table('children', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        if (Schema::hasTable('vaccine_records') && !Schema::hasColumn('vaccine_records', 'deleted_at')) {
            Schema::table('vaccine_records', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        if (Schema::hasTable('schedules') && !Schema::hasColumn('schedules', 'deleted_at')) {
            Schema::table('schedules', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        if (Schema::hasTable('payments') && !Schema::hasColumn('payments', 'deleted_at')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        if (Schema::hasTable('vaccines') && !Schema::hasColumn('vaccines', 'deleted_at')) {
            Schema::table('vaccines', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    public function down(): void {
        Schema::table('children', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('vaccine_records', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('vaccines', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
