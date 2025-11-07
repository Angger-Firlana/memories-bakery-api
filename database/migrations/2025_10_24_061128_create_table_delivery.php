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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')
            ->references('id')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreignId('courier_id')->constrained('couriers')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('address');
            $table->decimal('fee');
            $table->timestamp('delivery_date');
            $table->enum('status', ['pending', 'confirmation', 'to_ship', 'rejected', 'shipped'])->onDefault('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_delivery');
    }
};
