<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sms_otps', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('otp_code');
            $table->string('user_type'); // 'doctor' or 'parent'
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('purpose'); // 'password_reset', 'phone_verification'
            $table->integer('attempts')->default(0);
            $table->timestamp('expires_at');
            $table->boolean('used')->default(false);
            $table->timestamps();

            $table->index('phone');
            $table->index('expires_at');
        });
    }

    public function down(): void {
        Schema::dropIfExists('sms_otps');
    }
};
