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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id('po_id');
            $table->timestamp('order_date')->useCurrent();
            $table->date('expected_delivery_date')->nullable();
            $table->date('received_date')->nullable();
            $table->enum('Status', ['Pending', 'In Transit', 'Received', 'Cancelled'])->default('Pending'); // Pending, In Transit, Received, Cancelled
            $table->unsignedBigInteger('Supplier_ID')->nullable();
            $table->unsignedBigInteger('Employee_ID')->nullable();
            $table->decimal('total_amount', 12, 2)->nullable();
            $table->text('notes')->nullable();
            $table->enum('payment_status', ['Pending', 'Processing', 'Completed', 'Rejected'])->default('Pending');
            $table->timestamps();

            $table->index(['Supplier_ID', 'Employee_ID', 'order_date', 'status']);

            $table->foreign('Supplier_ID')
                ->references('Supplier_ID')->on('suppliers')
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
        Schema::dropIfExists('purchase_orders');
    }
};
