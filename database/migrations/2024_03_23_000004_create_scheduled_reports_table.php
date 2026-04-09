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
        Schema::create('scheduled_reports', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('report_type'); // financial, audit, inventory, coverage, vaccines
            $table->string('frequency'); // daily, weekly, monthly, quarterly
            $table->json('recipients'); // email addresses
            $table->json('filters')->nullable(); // date range, user type, model type, etc
            $table->dateTime('next_run_date');
            $table->dateTime('last_run_date')->nullable();
            $table->boolean('active')->default(true);
            $table->unsignedBigInteger('created_by_user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('created_by_user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheduled_reports');
    }
};
