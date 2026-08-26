<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tables whose translatable content is served in Macedonian as well as the
     * base English. Each gains a nullable JSON `translations` column that holds
     * per-locale field overrides (see App\Models\Concerns\HasTranslations).
     */
    private array $tables = [
        'pages',
        'sections',
        'posts',
        'daily_apex',
        'navigation_items',
        'site_settings',
    ];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            if (Schema::hasTable($table) && ! Schema::hasColumn($table, 'translations')) {
                Schema::table($table, function (Blueprint $blueprint) {
                    $blueprint->json('translations')->nullable()->after('id');
                });
            }
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'translations')) {
                Schema::table($table, function (Blueprint $blueprint) {
                    $blueprint->dropColumn('translations');
                });
            }
        }
    }
};
