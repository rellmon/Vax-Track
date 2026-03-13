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
        Schema::create('clinic_settings', function (Blueprint $table) {
            $table->id();
            $table->string('clinic_name')->default('VaccTrack Clinic');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('timezone')->default('Asia/Manila');
            $table->json('operating_hours')->nullable(); // {Monday: {is_open: true, open_time: "08:00", close_time: "17:00"}, ...}
            $table->decimal('consultation_fee', 8, 2)->default(500);
            $table->decimal('vaccine_service_fee', 8, 2)->default(200);
            $table->json('bank_details')->nullable(); // {bank_name, account_number, account_holder}
            $table->string('website')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->text('description')->nullable();
            $table->string('logo_url')->nullable();
            $table->timestamps();
        });

        // Insert default clinic settings
        DB::table('clinic_settings')->insert([
            'clinic_name' => env('APP_CLINIC_NAME', 'VaccTrack Clinic'),
            'phone' => '(02) 123-4567',
            'email' => 'clinic@vacctrack.ph',
            'address' => '123 Health Street',
            'city' => 'Manila',
            'province' => 'Metro Manila',
            'postal_code' => '1000',
            'timezone' => 'Asia/Manila',
            'operating_hours' => json_encode([
                'Monday' => ['is_open' => true, 'open_time' => '08:00', 'close_time' => '17:00'],
                'Tuesday' => ['is_open' => true, 'open_time' => '08:00', 'close_time' => '17:00'],
                'Wednesday' => ['is_open' => true, 'open_time' => '08:00', 'close_time' => '17:00'],
                'Thursday' => ['is_open' => true, 'open_time' => '08:00', 'close_time' => '17:00'],
                'Friday' => ['is_open' => true, 'open_time' => '08:00', 'close_time' => '17:00'],
                'Saturday' => ['is_open' => true, 'open_time' => '08:00', 'close_time' => '12:00'],
                'Sunday' => ['is_open' => false, 'open_time' => 'N/A', 'close_time' => 'N/A'],
            ]),
            'consultation_fee' => 500,
            'vaccine_service_fee' => 200,
            'description' => 'Professional vaccination and healthcare services for children and families.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinic_settings');
    }
};
