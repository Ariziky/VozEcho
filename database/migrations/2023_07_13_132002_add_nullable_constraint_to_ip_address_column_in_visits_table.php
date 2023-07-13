<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            if (Schema::hasColumn('visits', 'ip_address')) {
                $table->ipAddress()->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            //
        });
    }
};
