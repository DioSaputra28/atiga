<?php

namespace App\Observers;

use App\Models\Article;
use Illuminate\Support\Facades\Storage;

class ArticleObserver
{
    /**
     * Handle the Article "updating" event.
     * Delete old thumbnail when it's being replaced.
     */
    public function updating(Article $article): void
    {
        if ($article->isDirty('thumbnail')) {
            $oldThumbnail = $article->getOriginal('thumbnail');

            if (! empty($oldThumbnail) && Storage::disk('public')->exists($oldThumbnail)) {
                Storage::disk('public')->delete($oldThumbnail);
            }
        }
    }

    /**
     * Handle the Article "deleted" event.
     * Delete thumbnail when article is deleted.
     */
    public function deleted(Article $article): void
    {
        if (! empty($article->thumbnail) && Storage::disk('public')->exists($article->thumbnail)) {
            Storage::disk('public')->delete($article->thumbnail);
        }
    }
}
