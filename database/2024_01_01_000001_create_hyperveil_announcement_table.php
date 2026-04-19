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
            $table->string('type')->default('info');       // info | warning | danger | success
            $table->text('message')->default('');
            $table->string('link')->nullable();
            $table->string('link_text')->nullable();
            $table->timestamps();
        });

        // Seed a default row so there's always one record to UPDATE
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
