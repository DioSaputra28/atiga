<?php

namespace App\Observers;

use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerObserver
{
    /**
     * Handle the Banner "updating" event.
     *
     * Delete the old image file when image_path changes.
     */
    public function updating(Banner $banner): void
    {
        if ($banner->isDirty('image_path')) {
            $oldPath = $banner->getOriginal('image_path');

            if ($oldPath !== null && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }
    }

    /**
     * Handle the Banner "deleted" event.
     *
     * Delete the image file when banner is deleted.
     */
    public function deleted(Banner $banner): void
    {
        $path = $banner->getAttribute('image_path');

        if ($path !== null && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
