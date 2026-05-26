<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use MongoDB\Laravel\Schema\Blueprint;

return new class extends Migration
{
    protected $connection = 'mongodb';

    public function up(): void
    {
        Schema::connection('mongodb')->table('projects', function (Blueprint $collection) {
            $collection->unique('endpoint_slug');
            $collection->index('user_id');
        });

        Schema::connection('mongodb')->table('error_logs', function (Blueprint $collection) {
            $collection->index(['user_id', 'project_id', 'created_at']);
            $collection->index('severity_level');
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->table('projects', function (Blueprint $collection) {
            $collection->dropIndex('endpoint_slug_1');
            $collection->dropIndex('user_id_1');
        });

        Schema::connection('mongodb')->table('error_logs', function (Blueprint $collection) {
            $collection->dropIndex('user_id_1_project_id_1_created_at_1');
            $collection->dropIndex('severity_level_1');
        });
    }
};
