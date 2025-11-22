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
        Schema::create('returns', function (Blueprint $table) {
            $table->increments('return_id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->string('batch_number', 50)->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->integer('quantity_returned');
            $table->enum('Status', ['Pending', 'Processing', 'Completed', 'Rejected'])->default('Pending');
            $table->timestamp('return_date')->useCurrent();
            $table->text('reason')->nullable();
            $table->decimal('refund_amount', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('order_id')
                ->references('Order_ID')->on('orders')
                ->onDelete('set null');

            $table->foreign('batch_number')
                ->references('batch_number')->on('batches')
                ->onDelete('set null');

            $table->foreign('employee_id')
                ->references('id')->on('employees')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
