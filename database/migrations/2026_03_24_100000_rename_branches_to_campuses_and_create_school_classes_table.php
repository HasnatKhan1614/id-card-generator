<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('branches') && ! Schema::hasTable('campuses')) {
            Schema::rename('branches', 'campuses');
        }

        Schema::create('school_classes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_classes');

        if (Schema::hasTable('campuses') && ! Schema::hasTable('branches')) {
            Schema::rename('campuses', 'branches');
        }
    }
};
