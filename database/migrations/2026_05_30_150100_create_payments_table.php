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
    Schema::create('payments', function (Blueprint $table) {
        $table->id();

        $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
        $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();

        $table->decimal('amount', 12, 0);
        $table->string('payment_month')->nullable();
        $table->date('paid_at')->nullable();

        $table->string('receipt_path')->nullable();

        $table->enum('status', [
            'pending',
            'approved',
            'rejected'
        ])->default('pending');

        $table->text('admin_note')->nullable();
        $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
