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
            $table->renameColumn('date', 'due_day');
            $table->integer('due_day')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('variable_expenses', function (Blueprint $table) {
            $table->renameColumn('due_day', 'date');
            $table->date('date')->change();

        });
    }
};
