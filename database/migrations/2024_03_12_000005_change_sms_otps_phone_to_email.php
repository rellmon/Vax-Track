<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        if (Schema::hasTable('sms_otps') && Schema::hasColumn('sms_otps', 'phone')) {
            // SQLite doesn't support renaming columns easily, so we'll add email and use it
            if (!Schema::hasColumn('sms_otps', 'email')) {
                Schema::table('sms_otps', function (Blueprint $table) {
                    $table->string('email')->nullable()->after('phone');
                    $table->index('email');
                });
                
                // Copy data from phone to email (treat phone as email for now)
                DB::table('sms_otps')->update([
                    'email' => DB::raw('phone')
                ]);
            }
        }
    }

    public function down(): void {
        if (Schema::hasTable('sms_otps') && Schema::hasColumn('sms_otps', 'email')) {
            Schema::table('sms_otps', function (Blueprint $table) {
                $table->dropIndex('sms_otps_email_index');
                $table->dropColumn('email');
            });
        }
    }
};
