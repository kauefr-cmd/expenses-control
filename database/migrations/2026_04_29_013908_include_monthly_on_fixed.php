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
        Schema::table('fixed_expenses', function (Blueprint $table) {
            $table->foreignId('fixed_expense_template_id')->constrained();
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
        Schema::table('fixed_expenses', function (Blueprint $table) {
            //
        });
    }
};
