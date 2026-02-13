<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $heroSlides = [
            [
                'id' => 1,
                'image' => 'https://images.unsplash.com/photo-1560472355-536de3962603?w=1920&q=80',
                'title' => 'Promo Konsultasi Pajak untuk Perusahaan Menengah',
                'subtitle' => 'Diskon hingga 20% untuk paket review kepatuhan pajak bulanan selama periode promosi.',
                'cta_text' => 'Lihat Penawaran',
                'cta_link' => '/layanan',
            ],
            [
                'id' => 2,
                'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=1920&q=80',
                'title' => 'Paket Bundling Pelatihan Internal + Pendampingan SPT',
                'subtitle' => 'Solusi lengkap untuk tim finance: pelatihan praktis dan pendampingan pelaporan pajak.',
                'cta_text' => 'Daftar Program',
                'cta_link' => '/training',
            ],
            [
                'id' => 3,
                'image' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=1920&q=80',
                'title' => 'Konsultasi Gratis 30 Menit untuk Klien Baru',
                'subtitle' => 'Jadwalkan sesi awal tanpa biaya untuk memetakan risiko dan peluang perpajakan bisnis Anda.',
                'cta_text' => 'Jadwalkan Sekarang',
                'cta_link' => '/kontak',
            ],
        ];

        $featuredCards = [
            [
                'icon' => 'fa-calculator',
                'title' => 'Konsultasi Pajak',
                'description' => 'Pendampingan profesional untuk perencanaan dan pelaporan pajak Anda',
            ],
            [
                'icon' => 'fa-file-invoice',
                'title' => 'Pelaporan SPT',
                'description' => 'Bantuan penyusunan dan pengiriman Surat Pemberitahuan Tahunan',
            ],
            [
                'icon' => 'fa-building',
                'title' => 'Pajak Badan',
                'description' => 'Layanan lengkap untuk kepatuhan pajak perusahaan Anda',
            ],
            [
                'icon' => 'fa-users',
                'title' => 'Pelatihan',
                'description' => 'Program training perpajakan untuk meningkatkan kapasitas SDM',
            ],
        ];

        $articles = [
            [
                'id' => 1,
                'slug' => 'panduan-lapor-spt-tahunan-2025',
                'title' => 'Panduan Lengkap Lapor SPT Tahunan 2025',
                'excerpt' => 'Pelajari langkah-langkah penting dalam melaporkan SPT Tahunan untuk tahun pajak 2025, termasuk perubahan regulasi terbaru.',
                'image' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=800&q=80',
                'category' => 'Perpajakan',
                'published_at' => '2025-02-10',
                'author' => 'Tim Redaksi',
            ],
            [
                'id' => 2,
                'slug' => 'memahami-tax-amnesty-jilid-ii',
                'title' => 'Memahami Tax Amnesty Jilid II: Peluang dan Risiko',
                'excerpt' => 'Analisis mendalam tentang program pengampunan pajak terbaru dan bagaimana memanfaatkannya dengan bijak.',
                'image' => 'https://images.unsplash.com/photo-1554224154-26032ffc0d07?w=800&q=80',
                'category' => 'Regulasi',
                'published_at' => '2025-02-08',
                'author' => 'Budi Santoso',
            ],
            [
                'id' => 3,
                'slug' => 'strategi-tax-planning-untuk-umkm',
                'title' => 'Strategi Tax Planning Efektif untuk UMKM',
                'excerpt' => 'Tips dan trik mengoptimalkan beban pajak untuk usaha kecil dan menengah sesuai ketentuan yang berlaku.',
                'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&q=80',
                'category' => 'Bisnis',
                'published_at' => '2025-02-05',
                'author' => 'Siti Rahayu',
            ],
        ];

        $recommendedArticles = [
            [
                'id' => 4,
                'slug' => 'pph-21-terbaru-2025',
                'title' => 'Update PPh 21 Terbaru Tahun 2025',
                'category' => 'PPh 21',
                'published_at' => '2025-02-12',
            ],
            [
                'id' => 5,
                'slug' => 'cara-hitung-pajak-digital',
                'title' => 'Cara Menghitung Pajak Digital untuk Influencer',
                'category' => 'Pajak Digital',
                'published_at' => '2025-02-11',
            ],
            [
                'id' => 6,
                'slug' => 'kesalahan-umum-pelaporan-pajak',
                'title' => '5 Kesalahan Umum dalam Pelaporan Pajak',
                'category' => 'Kepatuhan',
                'published_at' => '2025-02-09',
            ],
            [
                'id' => 7,
                'slug' => 'pajak-perdagangan-internasional',
                'title' => 'Panduan Pajak untuk Perdagangan Internasional',
                'category' => 'Pajak Internasional',
                'published_at' => '2025-02-07',
            ],
        ];

        $regulations = [
            [
                'code' => 'PMK-9/2025',
                'title' => 'Peraturan Menteri Keuangan tentang Tata Cara Pemungutan Pajak',
                'date' => '2025-01-15',
            ],
            [
                'code' => 'SE-12/2025',
                'title' => 'Surat Edaran Dirjen Pajak terkait SPT Tahunan',
                'date' => '2025-01-20',
            ],
            [
                'code' => 'UU-HPP',
                'title' => 'Undang-Undang Harmonisasi Peraturan Perpajakan',
                'date' => '2024-12-28',
            ],
            [
                'code' => 'PER-23/2024',
                'title' => 'Peraturan Direktur Jenderal Pajak tentang e-Faktur',
                'date' => '2024-12-10',
            ],
        ];

        $galleryItems = [
            [
                'id' => 1,
                'image' => 'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=600&q=80',
                'title' => 'Workshop Pajak 2024',
                'description' => 'Pelatihan perpajakan untuk 100+ peserta dari berbagai industri',
            ],
            [
                'id' => 2,
                'image' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=600&q=80',
                'title' => 'Konsultasi Korporasi',
                'description' => 'Sesi konsultasi dengan klien korporasi terkait tax planning',
            ],
            [
                'id' => 3,
                'image' => 'https://images.unsplash.com/photo-1531545514256-b1400bc00f31?w=600&q=80',
                'title' => 'Seminar UMKM',
                'description' => 'Seminar pemahaman pajak bagi pelaku usaha mikro dan kecil',
            ],
            [
                'id' => 4,
                'image' => 'https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=600&q=80',
                'title' => 'Tim Konsultan',
                'description' => 'Team building konsultan pajak perusahaan kami',
            ],
        ];

        if (view()->exists('web.home')) {
            return view('web.home', compact(
                'heroSlides',
                'featuredCards',
                'articles',
                'recommendedArticles',
                'regulations',
                'galleryItems'
            ));
        }

        return view('welcome');
    }
}
