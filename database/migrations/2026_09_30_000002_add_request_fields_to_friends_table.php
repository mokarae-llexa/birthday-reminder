<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('friends', function (Blueprint $table) {
            if (!Schema::hasColumn('friends', 'created_by')) {
                $table->foreignId('created_by')
                    ->nullable()
                    ->after('linked_user_id')
                    ->constrained('users')
                    ->nullOnDelete();
            }
            if (!Schema::hasColumn('friends', 'request_status')) {
                $table->string('request_status', 20)->nullable()->after('created_by');
            }
        });

        DB::table('friends')
            ->whereNotNull('linked_user_id')
            ->whereNull('request_status')
            ->update(['request_status' => 'accepted']);
    }

    public function down(): void
    {
        Schema::table('friends', function (Blueprint $table) {
            $table->dropConstrainedForeignId('created_by');
            $table->dropColumn('request_status');
        });
    }
};
