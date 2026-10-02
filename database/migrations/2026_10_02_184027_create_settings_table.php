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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('My Application');
            $table->string('site_title')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('currency_name')->default('US Dollar');
            $table->string('currency_symbol')->default('$');
            $table->string('currency_code')->default('USD');
            $table->string('currency_position')->default('prefix');
            $table->string('pos_receipt_type')->default('pos');
            $table->string('purchase_receipt_type')->default('a5');
            $table->string('payment_receipt_type')->default('a4');
            $table->string('invoice_view_type')->default('both');
            $table->integer('low_stock_limit')->default(10);
            $table->boolean('dark_mode')->default(false);
            $table->string('favicon')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
