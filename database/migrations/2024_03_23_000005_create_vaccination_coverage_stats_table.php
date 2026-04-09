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
        Schema::create('vaccination_coverage_stats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vaccine_id');
            $table->date('report_date');
            $table->integer('target_population')->default(0); // expected children in age group
            $table->integer('vaccinated_count')->default(0); // children who received vaccine
            $table->decimal('coverage_percentage', 5, 2)->default(0);
            $table->json('demographics')->nullable(); // age groups, gender breakdown
            $table->timestamps();
            
            $table->foreign('vaccine_id')->references('id')->on('vaccines')->onDelete('cascade');
            $table->unique(['vaccine_id', 'report_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccination_coverage_stats');
    }
};
