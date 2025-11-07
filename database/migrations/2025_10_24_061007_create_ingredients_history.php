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
        Schema::create('ingredients_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained('branchs')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->timestamp('received_date');
            $table->integer('quantity');
            $table->timestamp('expired_date');
            $table->enum('status', ['old_stock', 'new_stock'])->default('new_stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients_history');
    }
};
