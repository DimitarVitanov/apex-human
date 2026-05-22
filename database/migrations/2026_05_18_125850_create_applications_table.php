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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->integer('age');
            $table->string('country');
            $table->text('current_state');
            $table->text('previous_experience');
            $table->text('twelve_month_goal');
            $table->boolean('gate_twelve_months')->default(false);
            $table->boolean('gate_four_hours')->default(false);
            $table->boolean('gate_pricing_call')->default(false);
            $table->boolean('gate_personal_use')->default(false);
            $table->string('status')->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
