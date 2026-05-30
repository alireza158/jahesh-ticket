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
    Schema::create('tickets', function (Blueprint $table) {
        $table->id();

        $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
        $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();

        $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
        $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();

        $table->string('title');
        $table->text('description');
        $table->string('phone')->nullable();
        $table->string('attachment_path')->nullable();

        $table->enum('priority', ['high', 'medium', 'low'])->default('medium');

        $table->enum('status', [
            'open',
            'in_progress',
            'waiting_customer',
            'answered',
            'closed'
        ])->default('open');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
