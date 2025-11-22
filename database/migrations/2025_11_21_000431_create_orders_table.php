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
            $table->id('Order_ID');
            $table->timestamp('Order_Date')->useCurrent();
            $table->decimal('Total_amount', 10, 2);
            $table->string('Payment_method', 50)->nullable();
            $table->enum('Status', ['Pending', 'Processing', 'Completed', 'Rejected'])->default('Pending');
            $table->unsignedBigInteger('Customer_ID')->nullable();
            $table->unsignedBigInteger('Employee_ID')->nullable();
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->text('delivery_address')->nullable();
            $table->string('delivery_type', 20)->nullable(); // Pickup or Delivery
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->foreign('Customer_ID')
                ->references('id')->on('customers')
                ->onDelete('set null');

            $table->foreign('Employee_ID')
                ->references('id')->on('employees')
                ->onDelete('set null');
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
