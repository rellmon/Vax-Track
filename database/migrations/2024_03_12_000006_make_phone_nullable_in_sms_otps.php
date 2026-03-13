<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::connection()->getDriverName();

        if ($driver === 'sqlite') {
            // SQLite doesn't support modifying columns directly
            // We need to recreate the table
            DB::statement('PRAGMA foreign_keys = OFF');

            // Create new table with phone as nullable
            DB::statement('
                CREATE TABLE sms_otps_new (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    email VARCHAR(255),
                    phone VARCHAR(20) NULL,
                    otp_code VARCHAR(6),
                    user_type VARCHAR(50),
                    user_id INTEGER,
                    purpose VARCHAR(255) DEFAULT "password_reset",
                    attempts INTEGER DEFAULT 0,
                    expires_at DATETIME,
                    used BOOLEAN DEFAULT 0,
                    created_at DATETIME,
                    updated_at DATETIME
                )
            ');

            // Copy data from old table
            DB::statement('INSERT INTO sms_otps_new SELECT * FROM sms_otps');

            // Drop old table and rename new one
            DB::statement('DROP TABLE sms_otps');
            DB::statement('ALTER TABLE sms_otps_new RENAME TO sms_otps');

            DB::statement('PRAGMA foreign_keys = ON');
        } else {
            // For other databases (MySQL, PostgreSQL, etc.)
            Schema::table('sms_otps', function (Blueprint $table) {
                $table->string('phone')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::connection()->getDriverName();

        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF');

            DB::statement('
                CREATE TABLE sms_otps_new (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    email VARCHAR(255),
                    phone VARCHAR(20) NOT NULL,
                    otp_code VARCHAR(6),
                    user_type VARCHAR(50),
                    user_id INTEGER,
                    purpose VARCHAR(255) DEFAULT "password_reset",
                    attempts INTEGER DEFAULT 0,
                    expires_at DATETIME,
                    used BOOLEAN DEFAULT 0,
                    created_at DATETIME,
                    updated_at DATETIME
                )
            ');

            DB::statement('INSERT INTO sms_otps_new SELECT * FROM sms_otps');
            DB::statement('DROP TABLE sms_otps');
            DB::statement('ALTER TABLE sms_otps_new RENAME TO sms_otps');

            DB::statement('PRAGMA foreign_keys = ON');
        } else {
            Schema::table('sms_otps', function (Blueprint $table) {
                $table->string('phone')->nullable(false)->change();
            });
        }
    }
};
