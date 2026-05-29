<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Custom Theme');
            $table->string('primary_color', 7)->default('#3B82F6');
            $table->string('primary_strong_color', 7)->default('#2563EB');
            $table->string('primary_dark_color', 7)->default('#1D4ED8');
            $table->string('primary_soft_color', 7)->default('#EFF6FF');
            $table->string('primary_border_color', 7)->default('#BFDBFE');
            $table->string('accent_color', 7)->default('#60A5FA');
            $table->string('muted_text_color', 7)->default('#64748B');
            $table->boolean('is_active')->default(false)->index();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        DB::table('themes')->insert([
            'name' => 'Blue Sky',
            'primary_color' => '#3B82F6',
            'primary_strong_color' => '#2563EB',
            'primary_dark_color' => '#1D4ED8',
            'primary_soft_color' => '#EFF6FF',
            'primary_border_color' => '#BFDBFE',
            'accent_color' => '#60A5FA',
            'muted_text_color' => '#64748B',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};
