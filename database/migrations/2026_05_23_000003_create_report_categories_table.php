<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('report_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('icon')->default('bi-exclamation-circle');
            $table->timestamps();
        });

        $now = now();
        DB::table('report_categories')->insert([
            ['name' => 'Roads', 'icon' => 'bi-signpost-2', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Street Lights', 'icon' => 'bi-lightbulb', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Garbage', 'icon' => 'bi-trash', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Flooding', 'icon' => 'bi-water', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Water Leakage', 'icon' => 'bi-droplet', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Drainage', 'icon' => 'bi-bezier2', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Electricity', 'icon' => 'bi-lightning-charge', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Traffic Lights', 'icon' => 'bi-stoplights', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Security', 'icon' => 'bi-shield-check', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Environment', 'icon' => 'bi-tree', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_categories');
    }
};
