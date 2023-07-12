<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('enregistrements', function (Blueprint $table) {
            $table->ipAddress()->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('enregistrements', function (Blueprint $table) {
            //
        });
    }
};
