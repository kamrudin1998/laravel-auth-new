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
        Schema::table('todos', function (Blueprint $table) {

            // description column
            if (!Schema::hasColumn('todos', 'description')) {
                $table->text('description')->nullable()->after('title');
            }

            // completed (status) column
            if (!Schema::hasColumn('todos', 'completed')) {
                $table->boolean('completed')->default(false);
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('todos', function (Blueprint $table) {

            if (Schema::hasColumn('todos', 'description')) {
                $table->dropColumn('description');
            }

            if (Schema::hasColumn('todos', 'completed')) {
                $table->dropColumn('completed');
            }

        });
    }
};
