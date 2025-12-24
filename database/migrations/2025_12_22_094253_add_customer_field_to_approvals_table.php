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
        Schema::table('approvals', function (Blueprint $table) {
            if (!Schema::hasColumn('approvals', 'customer_name')) {
                $table->string('customer_name')->nullable();
            }
            if (!Schema::hasColumn('approvals', 'customer_district')) {
                $table->string('customer_district')->nullable();
            }
            if (!Schema::hasColumn('approvals', 'customer_province')) {
                $table->string('customer_province')->nullable();
            }
            if (!Schema::hasColumn('approvals', 'customer_phone')) {
                $table->string('customer_phone')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('approvals', function (Blueprint $table) {
            $table->dropColumn([
                'customer_name',
                'customer_district',
                'customer_province',
                'customer_phone',
            ]);
        });
    }
};
