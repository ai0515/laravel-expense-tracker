<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\TransactionType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->date('transaction_date');
            $table->integer('amount')->default(0)->check('amount >= 0');
            $table->enum('transaction_type', [TransactionType::PAYMENT,TransactionType::INCOME])
                ->default(TransactionType::PAYMENT);
            $table->foreignId('payment_method_id')->constrained();
            $table->string('note', length: 100)->nullable();
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
