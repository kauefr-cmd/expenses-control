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
        Schema::table('variable_expenses', function (Blueprint $table) {
            $table->tinyInteger('installments')->default(1);
            $table->tinyInteger('current_installment')->default(1);
            $table->unsignedBigInteger('installment_group_id')->nullable();
            $table->tinyInteger('month');
            $table->year('year');
            $table->string('status')->default(\App\Enums\ExpenseStatus::Pending->value);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('variable_expenses', function (Blueprint $table) {
            //
        });
    }
};
