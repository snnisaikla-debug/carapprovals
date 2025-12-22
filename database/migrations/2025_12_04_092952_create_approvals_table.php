<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
            {
            Schema::create('approvals', function (Blueprint $table) {
            $table->id();

            $table->string('group_id');
            $table->integer('version')->default(1);

            $table->unsignedBigInteger('sales_user_id')->nullable();
            $table->string('sales_name')->nullable();

            $table->decimal('down_percent', 5, 2)->nullable();
            $table->decimal('down_amount', 10, 2)->nullable();
            $table->decimal('finance_amount', 10, 2)->nullable();

            $table->string('sc_signature')->nullable();
            $table->string('sale_com_signature')->nullable();

            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};
