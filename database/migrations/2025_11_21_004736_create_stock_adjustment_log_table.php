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
        Schema::create('stock_adjustment_log', function (Blueprint $table) {
            $table->id('adj_id');
            $table->string('batch_number', 50);
            $table->integer('previous_stock');
            $table->integer('new_stock');
            $table->integer('difference');
            $table->unsignedBigInteger('adjusted_by')->nullable();
            $table->timestamp('adjusted_at')->useCurrent();
            $table->string('reason', 100);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('batch_number')
                ->references('batch_number')->on('batches')
                ->onDelete('restrict');

            $table->foreign('adjusted_by')
                ->references('id')->on('employees')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_adjustment_log');
    }
};
