<?php

use App\Models\Enregistrement;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listenings', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->foreignIdFor(Enregistrement::class)->constrained();
            $table->ipAddress();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listenings');
    }
};
