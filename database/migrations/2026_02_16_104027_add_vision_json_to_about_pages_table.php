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
        if (! Schema::hasColumn('about_pages', 'vision_json')) {
            Schema::table('about_pages', function (Blueprint $table): void {
                $table->json('vision_json')->default(json_encode([]));
            });
        }

        if (Schema::hasColumn('about_pages', 'vision_text') && Schema::hasColumn('about_pages', 'vision_json')) {
            DB::table('about_pages')
                ->select(['id', 'vision_text'])
                ->orderBy('id')
                ->chunkById(100, function ($aboutPages): void {
                    foreach ($aboutPages as $aboutPage) {
                        $visionText = is_string($aboutPage->vision_text) ? trim($aboutPage->vision_text) : '';

                        if ($visionText === '') {
                            continue;
                        }

                        DB::table('about_pages')
                            ->where('id', $aboutPage->id)
                            ->update([
                                'vision_json' => json_encode([
                                    ['text' => $visionText],
                                ]),
                            ]);
                    }
                }, 'id');
        }

        if (Schema::hasColumn('about_pages', 'vision_text')) {
            Schema::table('about_pages', function (Blueprint $table): void {
                $table->dropColumn('vision_text');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('about_pages', 'vision_text')) {
            Schema::table('about_pages', function (Blueprint $table): void {
                $table->text('vision_text')->nullable();
            });
        }

        if (Schema::hasColumn('about_pages', 'vision_json') && Schema::hasColumn('about_pages', 'vision_text')) {
            DB::table('about_pages')
                ->select(['id', 'vision_json'])
                ->orderBy('id')
                ->chunkById(100, function ($aboutPages): void {
                    foreach ($aboutPages as $aboutPage) {
                        $visionJson = $aboutPage->vision_json;

                        if (is_string($visionJson)) {
                            $visionJson = json_decode($visionJson, true);
                        }

                        $visionText = is_array($visionJson)
                            ? trim((string) ($visionJson[0]['text'] ?? ''))
                            : '';

                        DB::table('about_pages')
                            ->where('id', $aboutPage->id)
                            ->update([
                                'vision_text' => $visionText !== '' ? $visionText : null,
                            ]);
                    }
                }, 'id');
        }

        if (Schema::hasColumn('about_pages', 'vision_json')) {
            Schema::table('about_pages', function (Blueprint $table): void {
                $table->dropColumn('vision_json');
            });
        }
    }
};
