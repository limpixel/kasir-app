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
        Schema::table('transactions', function (Blueprint $table) {
            // Add address fields
            $table->string('province')->nullable()->after('customer_address');
            $table->string('city')->nullable()->after('province');
            $table->string('district')->nullable()->after('city');
            $table->string('ward')->nullable()->after('district');
            
            // Add shipping cost field
            $table->bigInteger('shipping_cost')->default(0)->after('ward');
            
            // Add payment status field for tracking e-wallet payments
            $table->string('payment_status')->default('pending')->after('status');
            
            // Add payment details field for storing e-wallet transaction info
            $table->json('payment_details')->nullable()->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'province',
                'city', 
                'district',
                'ward',
                'shipping_cost',
                'payment_status',
                'payment_details'
            ]);
        });
    }
};
