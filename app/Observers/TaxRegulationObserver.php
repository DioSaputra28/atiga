<?php

namespace App\Observers;

use App\Models\TaxRegulation;
use Illuminate\Support\Facades\Storage;

class TaxRegulationObserver
{
    public function updating(TaxRegulation $taxRegulation): void
    {
        if ($taxRegulation->isDirty('document_path')) {
            $oldPath = $taxRegulation->getOriginal('document_path');

            if (! empty($oldPath) && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }
    }

    public function deleted(TaxRegulation $taxRegulation): void
    {
        $path = $taxRegulation->getAttribute('document_path');

        if (! empty($path) && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
