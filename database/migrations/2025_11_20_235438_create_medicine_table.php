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
        Schema::create('medicine', function (Blueprint $table) {
            $table->id('medicine_id');
            $table->string('Name', 200);
            $table->string('Category', 50)->nullable();
            $table->decimal('Price', 10, 2);
            $table->integer('Stock')->default(0);
            $table->text('Description')->nullable();
            
            $table->string('img', 100);
            $table->integer('low_stock_threshold')->default(10);
            $table->string('generic_name', 200)->nullable();
            $table->string('manufacturer', 100)->nullable();
            $table->enum('dosage_form', ['Tablet', 'Capsule', 'Syrup', 'Injection'])->default('Tablet');
            $table->string('strength', 50)->nullable(); // e.g., 500mg
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['Name', 'Category']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine');
    }
};
