<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('about_pages', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title');
            $table->string('hero_subtitle');
            $table->text('intro_text');
            $table->json('stats_json')->default(json_encode([]));
            $table->text('vision_text');
            $table->json('mission_json')->default(json_encode([]));
            $table->json('core_values_json')->default(json_encode([]));
            $table->string('cta_title');
            $table->text('cta_description');
            $table->string('cta_label');
            $table->string('cta_url');
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_pages');
    }
};
