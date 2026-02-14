<?php

use App\Models\TaxRegulation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

it('creates tax regulations table with required columns', function (): void {
    expect(Schema::hasTable('tax_regulations'))->toBeTrue();

    expect(Schema::hasColumns('tax_regulations', [
        'title',
        'description',
        'document_path',
        'document_name',
        'youtube_url',
        'is_published',
        'published_at',
        'sort_order',
        'created_at',
        'updated_at',
    ]))->toBeTrue();
});

it('deletes previous document file when document path changes', function (): void {
    Storage::fake('public');

    Storage::disk('public')->put('tax-regulations/old-file.pdf', 'old');

    $taxRegulation = TaxRegulation::factory()->create([
        'document_path' => 'tax-regulations/old-file.pdf',
    ]);

    $taxRegulation->update([
        'document_path' => 'tax-regulations/new-file.pdf',
    ]);

    expect(Storage::disk('public')->exists('tax-regulations/old-file.pdf'))->toBeFalse();
});

it('deletes document file when tax regulation is deleted', function (): void {
    Storage::fake('public');

    Storage::disk('public')->put('tax-regulations/file-to-delete.pdf', 'file');

    $taxRegulation = TaxRegulation::factory()->create([
        'document_path' => 'tax-regulations/file-to-delete.pdf',
    ]);

    $taxRegulation->delete();

    expect(Storage::disk('public')->exists('tax-regulations/file-to-delete.pdf'))->toBeFalse();
});
