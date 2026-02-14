<?php

namespace App\Observers;

use App\Models\Activity;
use Illuminate\Support\Facades\Storage;

class ActivityObserver
{
    /**
     * Handle the Activity "deleted" event.
     *
     * Deletes associated image files from the public storage disk.
     */
    public function deleted(Activity $activity): void
    {
        foreach ($activity->images as $image) {
            if (! empty($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
                Storage::disk('local')->delete($image->image_path);
            }
        }
    }
}
