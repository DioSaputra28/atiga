<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use App\Models\ServicesPage;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        $aboutPage = AboutPage::find(1);

        if ($aboutPage === null || ! $aboutPage->is_published) {
            abort(404);
        }

        $statIcons = [
            'fa-calendar-days',
            'fa-users',
            'fa-handshake',
            'fa-location-dot',
        ];

        $stats = array_values(array_map(
            static function (mixed $item, int $index) use ($statIcons): array {
                $stat = is_array($item) ? $item : [];

                return [
                    'label' => (string) ($stat['label'] ?? ''),
                    'value' => (string) ($stat['value'] ?? ''),
                    'suffix' => isset($stat['suffix']) ? (string) $stat['suffix'] : '',
                    'icon' => $statIcons[$index % count($statIcons)],
                ];
            },
            $aboutPage->stats_json ?? [],
            array_keys($aboutPage->stats_json ?? [])
        ));

        $mission = array_values(array_filter(array_map(
            static fn (mixed $item): string => is_array($item) ? (string) ($item['text'] ?? '') : '',
            $aboutPage->mission_json ?? []
        ), static fn (string $text): bool => $text !== ''));

        $visionEntries = is_array($aboutPage->vision_json ?? null)
            ? $aboutPage->vision_json
            : [];

        $visionItems = array_values(array_filter(array_map(
            static fn (mixed $item): string => is_array($item) ? trim((string) ($item['text'] ?? '')) : '',
            $visionEntries
        ), static fn (string $text): bool => $text !== ''));

        if ($visionItems === []) {
            $legacyVisionText = trim((string) ($aboutPage->getAttribute('vision_text') ?? ''));

            if ($legacyVisionText !== '') {
                $visionItems = [$legacyVisionText];
            }
        }

        $values = array_values(array_filter(array_map(
            static function (mixed $item): array {
                $value = is_array($item) ? $item : [];
                $icon = (string) ($value['icon'] ?? 'fa-circle-check');

                if ($icon !== '' && ! str_starts_with($icon, 'fa-')) {
                    $icon = 'fa-'.$icon;
                }

                return [
                    'icon' => $icon,
                    'title' => (string) ($value['title'] ?? ''),
                    'description' => (string) ($value['description'] ?? ''),
                ];
            },
            $aboutPage->core_values_json ?? []
        ), static fn (array $item): bool => $item['title'] !== '' || $item['description'] !== ''));

        return view('web.about', [
            'heroLabel' => $aboutPage->hero_subtitle,
            'heroTitle' => $aboutPage->hero_title,
            'heroSubtitle' => $aboutPage->hero_subtitle,
            'introText' => $aboutPage->intro_text,
            'stats' => $stats,
            'visionLabel' => 'Visi Kami',
            'visionItems' => $visionItems,
            'visionText' => $visionItems[0] ?? '',
            'missionLabel' => 'Misi Kami',
            'mission' => $mission,
            'values' => $values,
            'ctaTitle' => $aboutPage->cta_title,
            'ctaDescription' => $aboutPage->cta_description,
            'ctaLabel' => $aboutPage->cta_label,
            'ctaUrl' => $aboutPage->cta_url,
        ]);
    }

    public function services(): View
    {
        $page = ServicesPage::find(1);

        if ($page === null || ! $page->is_published) {
            abort(404);
        }

        $mainServices = array_values(array_filter(array_map(
            static function (mixed $item): ?array {
                if (! is_array($item)) {
                    return null;
                }

                $title = trim((string) ($item['title'] ?? ''));
                $description = trim((string) ($item['description'] ?? ''));

                if ($title === '' && $description === '') {
                    return null;
                }

                $icon = trim((string) ($item['icon'] ?? ''));
                if ($icon !== '' && ! str_starts_with($icon, 'fa-')) {
                    $icon = 'fa-'.$icon;
                }

                $features = isset($item['features']) && is_array($item['features'])
                    ? $item['features']
                    : [];

                $features = array_values(array_filter(
                    $features,
                    static fn (mixed $f): bool => is_string($f) && trim($f) !== ''
                ));

                return [
                    'id' => $item['id'] ?? null,
                    'icon' => $icon,
                    'title' => $title,
                    'description' => $description,
                    'features' => $features,
                ];
            },
            $page->main_services_json ?? []
        )));

        return view('web.services', [
            'heroBadge' => $page->hero_badge,
            'heroTitle' => $page->hero_title,
            'heroHighlight' => $page->hero_highlight,
            'heroDescription' => $page->hero_description,
            'mainServices' => $mainServices,
        ]);
    }

    public function contact(): View
    {
        $whatsappNumber = preg_replace('/\D+/', '', (string) site_social_whatsapp(''));
        $companyEmail = site_company_email('');

        $contactInfo = [
            'address' => site_company_location(''),
            'address_detail' => '',
            'phone' => site_phone_number(''),
            'whatsapp' => site_social_whatsapp(''),
            'email' => $companyEmail,
            'hours' => site_operational_hours(''),
        ];

        $contactActionUrl = $whatsappNumber !== ''
            ? "https://wa.me/{$whatsappNumber}"
            : "mailto:{$companyEmail}";

        $officeLocations = [
            [
                'name' => 'Kantor Pusat Jakarta',
                'address' => 'Jl. Sudirman Kav. 52-53, Jakarta Selatan',
                'map_embed' => 'https://maps.google.com/embed?pb=!1m18!1m12!1m3!1d3966.5!2d106.8!3d-6.2!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTInMDAuMCJTIDEwNsKwNDgnMDAuMCJF!5e0!3m2!1sen!2sid!4v1234567890',
            ],
            [
                'name' => 'Kantor Cabang Surabaya',
                'address' => 'Jl. Pemuda No. 50, Surabaya, Jawa Timur',
                'map_embed' => 'https://maps.google.com/embed?pb=!1m18!1m12!1m3!1d3957.5!2d112.7!3d-7.2!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMTInMDAuMCJTIDExMsKwNDInMDAuMCJF!5e0!3m2!1sen!2sid!4v1234567890',
            ],
            [
                'name' => 'Kantor Cabang Bandung',
                'address' => 'Jl. Braga No. 25, Bandung, Jawa Barat',
                'map_embed' => 'https://maps.google.com/embed?pb=!1m18!1m12!1m3!1d3960.8!2d107.6!3d-6.9!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNTQnMDAuMCJTIDEwN8KwMzYnMDAuMCJF!5e0!3m2!1sen!2sid!4v1234567890',
            ],
        ];

        $faqItems = [
            [
                'question' => 'Bagaimana cara memulai konsultasi?',
                'answer' => 'Anda dapat menghubungi kami melalui telepon, email, atau mengisi formulir kontak. Tim kami akan menjadwalkan konsultasi awal secara gratis.',
            ],
            [
                'question' => 'Berapa biaya jasa konsultasi pajak?',
                'answer' => 'Biaya bervariasi tergantung kompleksitas dan jenis layanan. Kami akan memberikan penawaran harga setelah diskusi awal.',
            ],
            [
                'question' => 'Apakah melayani konsultasi online?',
                'answer' => 'Ya, kami menyediakan layanan konsultasi virtual melalui video call untuk klien di luar kota.',
            ],
            [
                'question' => 'Berapa lama proses konsultasi?',
                'answer' => 'Durasi bervariasi. Konsultasi sederhana bisa 1-2 jam, sementara proyek kompleks memerlukan beberapa minggu.',
            ],
        ];

        return view('web.contact', compact(
            'contactInfo',
            'contactActionUrl',
            'officeLocations',
            'faqItems'
        ));
    }
}
