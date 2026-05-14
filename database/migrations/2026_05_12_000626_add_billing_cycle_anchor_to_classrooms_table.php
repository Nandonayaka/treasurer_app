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
        Schema::table('classrooms', function (Blueprint $table) {
            $table->timestamp('billing_cycle_anchor')->nullable()->after('billing_at_time');
            $table->decimal('accumulated_expected_fees', 15, 2)->default(0)->after('billing_cycle_anchor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classrooms', function (Blueprint $table) {
            $table->dropColumn(['billing_cycle_anchor', 'accumulated_expected_fees']);
        });
    }
};
