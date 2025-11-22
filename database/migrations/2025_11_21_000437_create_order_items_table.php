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
        Schema::create('order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('Order_ID');
            $table->unsignedBigInteger('medicine_id');
            $table->integer('Quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount_applied', 10, 2)->default(0);
            $table->string('batch_number', 50)->nullable();
            $table->timestamps();

            $table->primary(['Order_ID', 'medicine_id']);

            $table->foreign('Order_ID')
                ->references('Order_ID')->on('orders')
                ->onDelete('cascade');

            $table->foreign('medicine_id')
                ->references('medicine_id')->on('medicine')
                ->onDelete('cascade');

            $table->foreign('batch_number')
                ->references('batch_number')->on('batches')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
