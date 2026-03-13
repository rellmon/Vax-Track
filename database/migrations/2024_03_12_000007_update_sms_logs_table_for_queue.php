<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sms_logs', function (Blueprint $table) {
            // Rename 'phone' to 'phone_number' and make it more specific
            if (!Schema::hasColumn('sms_logs', 'phone_number') && Schema::hasColumn('sms_logs', 'phone')) {
                $table->renameColumn('phone', 'phone_number');
            }

            // Add new columns if they don't exist
            if (!Schema::hasColumn('sms_logs', 'status')) {
                $table->string('status')->default('pending')->after('message'); // pending, queued, sent, failed, failed_permanently
            }

            if (!Schema::hasColumn('sms_logs', 'sent_at')) {
                $table->timestamp('sent_at')->nullable()->after('status');
            }

            if (!Schema::hasColumn('sms_logs', 'response')) {
                $table->json('response')->nullable()->after('sent_at');
            }

            if (!Schema::hasColumn('sms_logs', 'error_message')) {
                $table->text('error_message')->nullable()->after('response');
            }

            if (!Schema::hasColumn('sms_logs', 'retry_count')) {
                $table->integer('retry_count')->default(0)->after('error_message');
            }

            if (!Schema::hasColumn('sms_logs', 'context')) {
                $table->json('context')->nullable()->after('retry_count');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sms_logs', function (Blueprint $table) {
            if (Schema::hasColumn('sms_logs', 'context')) {
                $table->dropColumn('context');
            }

            if (Schema::hasColumn('sms_logs', 'retry_count')) {
                $table->dropColumn('retry_count');
            }

            if (Schema::hasColumn('sms_logs', 'error_message')) {
                $table->dropColumn('error_message');
            }

            if (Schema::hasColumn('sms_logs', 'response')) {
                $table->dropColumn('response');
            }

            if (Schema::hasColumn('sms_logs', 'sent_at')) {
                $table->dropColumn('sent_at');
            }

            if (Schema::hasColumn('sms_logs', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
