<?php

use App\Models\TaxRegulation;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\get;

it('deletes the previous document when tax regulation document is replaced', function (): void {
    Storage::fake('public');

    $oldDocumentPath = 'tax-regulations/old-regulation.pdf';
    $newDocumentPath = 'tax-regulations/new-regulation.pdf';

    Storage::disk('public')->put($oldDocumentPath, 'old document');
    Storage::disk('public')->put($newDocumentPath, 'new document');

    $taxRegulation = TaxRegulation::factory()->create([
        'title' => 'PMK-9/2025',
        'description' => 'Ketentuan pajak terbaru',
        'document_path' => $oldDocumentPath,
        'document_name' => 'Dokumen Lama',
        'youtube_url' => null,
        'is_published' => true,
        'published_at' => now()->subDay(),
        'sort_order' => 1,
    ]);

    $taxRegulation->update([
        'document_path' => $newDocumentPath,
    ]);

    expect(Storage::disk('public')->exists($oldDocumentPath))->toBeFalse();
    expect(Storage::disk('public')->exists($newDocumentPath))->toBeTrue();
});

it('deletes document from storage when tax regulation is deleted', function (): void {
    Storage::fake('public');

    $documentPath = 'tax-regulations/deleted-regulation.pdf';

    Storage::disk('public')->put($documentPath, 'document payload');

    $taxRegulation = TaxRegulation::factory()->create([
        'title' => 'SE-12/2025',
        'description' => 'Surat edaran pajak',
        'document_path' => $documentPath,
        'document_name' => 'Dokumen Akan Dihapus',
        'youtube_url' => null,
        'is_published' => true,
        'published_at' => now()->subDay(),
        'sort_order' => 2,
    ]);

    $taxRegulation->delete();

    expect(Storage::disk('public')->exists($documentPath))->toBeFalse();
});

it('renders published tax regulation title on home page', function (): void {
    TaxRegulation::factory()->create([
        'title' => 'Peraturan Pajak Penghasilan Badan 2026',
        'description' => 'Regulasi yang harus tampil di beranda',
        'document_path' => null,
        'document_name' => null,
        'youtube_url' => null,
        'is_published' => true,
        'published_at' => now()->subHour(),
        'sort_order' => 1,
    ]);

    TaxRegulation::factory()->create([
        'title' => 'Draft Internal Regulasi',
        'description' => 'Tidak boleh tampil karena belum dipublikasikan',
        'document_path' => null,
        'document_name' => null,
        'youtube_url' => null,
        'is_published' => false,
        'published_at' => now()->subHour(),
        'sort_order' => 2,
    ]);

    $response = get('/');

    $response->assertOk();
    $response->assertSeeText('Peraturan Pajak Penghasilan Badan 2026');
    $response->assertDontSeeText('Draft Internal Regulasi');
});

it('renders tax regulation details with document download and youtube embed', function (): void {
    TaxRegulation::factory()->create([
        'title' => 'PMK-9/2025',
        'description' => 'Ringkasan perubahan aturan perpajakan terbaru.',
        'document_path' => 'tax-regulations/pmk-9-2025.pdf',
        'document_name' => null,
        'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'is_published' => true,
        'published_at' => now()->subDay(),
        'sort_order' => 1,
    ]);

    TaxRegulation::factory()->create([
        'title' => 'SE-12/2025',
        'description' => 'Panduan sosialisasi ketentuan pajak.',
        'document_path' => 'tax-regulations/se-12-2025.pdf',
        'document_name' => 'Dokumen Sosialisasi',
        'youtube_url' => 'https://youtu.be/9bZkp7q19f0',
        'is_published' => true,
        'published_at' => now()->subHours(3),
        'sort_order' => 2,
    ]);

    TaxRegulation::factory()->create([
        'title' => 'Regulasi dengan tautan video tidak valid',
        'description' => 'Tidak boleh menghasilkan embed iframe.',
        'document_path' => null,
        'document_name' => null,
        'youtube_url' => 'https://example.com/watch?v=12345678901',
        'is_published' => true,
        'published_at' => now()->subHours(5),
        'sort_order' => 3,
    ]);

    $response = get('/');

    $response->assertOk();
    $response->assertSeeText('PMK-9/2025');
    $response->assertSeeText('Ringkasan perubahan aturan perpajakan terbaru.');
    $response->assertSee('href="/storage/tax-regulations/pmk-9-2025.pdf"', false);
    $response->assertSeeText('Unduh Dokumen');
    $response->assertSeeText('Dokumen Sosialisasi');
    $response->assertSee('src="https://www.youtube.com/embed/dQw4w9WgXcQ"', false);
    $response->assertSee('src="https://www.youtube.com/embed/9bZkp7q19f0"', false);
    $response->assertDontSee('src="https://www.youtube.com/embed/12345678901"', false);
});
