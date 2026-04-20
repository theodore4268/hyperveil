<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hyperveil_announcement', function (Blueprint $table) {
            $table->id();
            $table->boolean('visible')->default(false);
            $table->string('type', 20)->default('info');
            $table->text('message')->nullable();
            $table->string('link', 255)->nullable();
            $table->string('link_text', 60)->nullable();
            $table->timestamps();
        });

        // Seed a default row — always one record, we UPDATE not INSERT
        DB::table('hyperveil_announcement')->insert([
            'visible'    => false,
            'type'       => 'info',
            'message'    => 'Welcome to HyperVeil!',
            'link'       => null,
            'link_text'  => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('hyperveil_announcement');
    }
};
