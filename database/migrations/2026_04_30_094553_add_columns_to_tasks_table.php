<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Ajoute priority seulement si elle n'existe pas
            if (!Schema::hasColumn('tasks', 'priority')) {
                $table->enum('priority', ['urgent', 'haute', 'moyenne', 'basse'])->default('moyenne')->after('description');
            }

            // Ajoute due_date seulement si elle n'existe pas
            if (!Schema::hasColumn('tasks', 'due_date')) {
                $table->date('due_date')->nullable()->after('priority');
            }

            // Ajoute is_completed seulement si elle n'existe pas
            if (!Schema::hasColumn('tasks', 'is_completed')) {
                $table->boolean('is_completed')->default(false)->after('due_date');
            }
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['priority', 'due_date', 'is_completed']);
        });
    }
};