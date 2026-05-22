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
        Schema::table('applications', function (Blueprint $table) {
            $table->text('why_now')->nullable()->after('current_state');
            $table->string('commitment')->nullable()->after('twelve_month_goal');
            $table->string('investment')->nullable()->after('commitment');
            $table->dropColumn(['gate_twelve_months', 'gate_four_hours', 'gate_pricing_call', 'gate_personal_use']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['why_now', 'commitment', 'investment']);
            $table->boolean('gate_twelve_months')->default(false);
            $table->boolean('gate_four_hours')->default(false);
            $table->boolean('gate_pricing_call')->default(false);
            $table->boolean('gate_personal_use')->default(false);
        });
    }
};
