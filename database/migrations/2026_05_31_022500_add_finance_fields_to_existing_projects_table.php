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
        if (! Schema::hasTable('projects')) {
            return;
        }

        Schema::table('projects', function (Blueprint $table) {
            if (! Schema::hasColumn('projects', 'initial_fee')) {
                $table->decimal('initial_fee', 12, 0)->default(0);
            }

            if (! Schema::hasColumn('projects', 'monthly_fee')) {
                $table->decimal('monthly_fee', 12, 0)->default(0);
            }

            if (! Schema::hasColumn('projects', 'debt_adjustment')) {
                $table->decimal('debt_adjustment', 12, 0)->default(0);
            }

            if (! Schema::hasColumn('projects', 'credit_adjustment')) {
                $table->decimal('credit_adjustment', 12, 0)->default(0);
            }

            if (! Schema::hasColumn('projects', 'finance_note')) {
                $table->text('finance_note')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('projects')) {
            return;
        }

        $columns = array_filter([
            Schema::hasColumn('projects', 'initial_fee') ? 'initial_fee' : null,
            Schema::hasColumn('projects', 'monthly_fee') ? 'monthly_fee' : null,
            Schema::hasColumn('projects', 'debt_adjustment') ? 'debt_adjustment' : null,
            Schema::hasColumn('projects', 'credit_adjustment') ? 'credit_adjustment' : null,
            Schema::hasColumn('projects', 'finance_note') ? 'finance_note' : null,
        ]);

        if ($columns === []) {
            return;
        }

        Schema::table('projects', function (Blueprint $table) use ($columns) {
            $table->dropColumn($columns);
        });
    }
};
