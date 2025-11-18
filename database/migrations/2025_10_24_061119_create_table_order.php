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
             $table->foreignId('branch_id')->constrained('branchs')
            ->onDelete('cascade')
            ->onUpdate('cascade');
             $table->foreignId('customer_id')->constrained('customers')
            ->onDelete('cascade')
            ->onUpdate('cascade');
             $table->foreignId('employee_id')->constrained('employees')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('customer_name');
            $table->timestamp('order_date');
            $table->string('address');
            $table->string('customer_phone');
            $table->enum('status', ['pending', 'confirmation', 'finished', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_order');
    }
};
