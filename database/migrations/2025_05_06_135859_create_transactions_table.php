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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('sender_account_id')->nullable()->constrained('accounts')->onDelete('cascade');
            $table->foreignUuid('receiver_account_id')->constrained('accounts')->onDelete('cascade');
            $table->foreignUuid('reversed_transaction_id')->nullable()->constrained('transactions')->nullOnDelete();
            $table->decimal('amount', 15, 2);
            $table->string('type');
            $table->string('status')->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
