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
        Schema::create('batches', function (Blueprint $table) {
           $table->string('batch_number', 50)->primary();
            $table->date('exp_date');
            $table->date('mfg_date');
            $table->integer('quantity');
            $table->decimal('purchase_price', 10, 2);
            $table->unsignedBigInteger('medicine_id')->nullable();
            $table->unsignedBigInteger('po_id')->nullable();
            $table->integer('current_stock')->default(0);
            $table->decimal('cost_per_unit', 10, 2)->nullable();
            $table->string('supplier_batch_ref', 50)->nullable();
            $table->timestamps();

            $table->index(['medicine_id', 'po_id', 'exp_date']);

            // Foreign keys (nullable to allow creating batches before linking PO if needed)
            $table->foreign('medicine_id')
                  ->references('medicine_id')->on('medicine')
                  ->onUpdate('cascade')
                  ->onDelete('set null');

            // Note: purchase_orders migration will create 'purchase_orders' table with po_id
            $table->foreign('po_id')
                  ->references('po_id')->on('purchase_orders')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
