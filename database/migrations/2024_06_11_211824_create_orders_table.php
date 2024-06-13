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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('first_name', 255);
            $table->string('last_name', 255)->nullable();
            $table->string('company_name', 255)->nullable();
            $table->string('country', 255)->nullable();
            $table->string('address_one', 255)->nullable();
            $table->string('address_two', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('county', 255)->nullable();
            $table->string('postcode', 255)->nullable();
            $table->string('phone')->nullable();
            $table->string('email', 255)->nullable();
            $table->text('note')->nullable();
            $table->string('discount_code', 255)->nullable();
            $table->string('discount_amount', 25);
            $table->integer('shipping_id')->nullable();
            $table->string('shipping_amount', 25);
            $table->string('total_amount', 25);
            $table->string('payment_method', 25)->nullable();
            $table->integer('status');
            $table->integer('is_delete');
            $table->integer('is_payment')->nullable();
            $table->text('payment_data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
