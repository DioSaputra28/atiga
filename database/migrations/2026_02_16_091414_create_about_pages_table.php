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
        $driver = DB::getDriverName();

        Schema::create('about_pages', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title');
            $table->string('hero_subtitle');
            $table->text('intro_text');
            $table->json('stats_json');
            $table->text('vision_text');
            $table->json('mission_json');
            $table->json('core_values_json');
            $table->string('cta_title');
            $table->text('cta_description');
            $table->string('cta_label');
            $table->string('cta_url');
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE about_pages MODIFY stats_json JSON NOT NULL DEFAULT (JSON_ARRAY())');
            DB::statement('ALTER TABLE about_pages MODIFY mission_json JSON NOT NULL DEFAULT (JSON_ARRAY())');
            DB::statement('ALTER TABLE about_pages MODIFY core_values_json JSON NOT NULL DEFAULT (JSON_ARRAY())');
        }

        if ($driver === 'pgsql') {
            DB::statement("ALTER TABLE about_pages ALTER COLUMN stats_json SET DEFAULT '[]'::json");
            DB::statement("ALTER TABLE about_pages ALTER COLUMN mission_json SET DEFAULT '[]'::json");
            DB::statement("ALTER TABLE about_pages ALTER COLUMN core_values_json SET DEFAULT '[]'::json");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_pages');
    }
};
