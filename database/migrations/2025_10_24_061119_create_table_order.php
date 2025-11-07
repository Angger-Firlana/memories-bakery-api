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
             $table->foreignId('menu_id')->constrained('menus')
            ->onDelete('cascade')
            ->onUpdate('cascade');
             $table->foreignId('customer_id')->constrained('customers')
            ->onDelete('cascade')
            ->onUpdate('cascade');
             $table->foreignId('employee_id')->constrained('employees')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->timestamp('orderDate');
            $table->string('address');
            $table->string('phoneNumber');
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
