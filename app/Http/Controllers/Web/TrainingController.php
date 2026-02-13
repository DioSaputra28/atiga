<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class TrainingController extends Controller
{
    public function index(): View
    {
        $trainings = [
            [
                'id' => 1,
                'slug' => 'brevet-pajak-a',
                'title' => 'Brevet Pajak A',
                'subtitle' => 'Sertifikasi Perpajakan Dasar',
                'description' => 'Program sertifikasi untuk memahami dasar-dasar perpajakan di Indonesia, termasuk PPh Pasal 21, 23, 26, dan PPN. Cocok untuk pemula dan staf pajak.',
                'image' => 'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=800&q=80',
                'duration' => '5 Hari',
                'schedule' => 'Maret, Juni, September, Desember',
                'price' => 'Rp 3.500.000',
                'discounted_price' => 'Rp 2.800.000',
                'format' => 'Online / Offline',
                'category' => 'Sertifikasi',
                'level' => 'Dasar',
                'instructor' => 'Dr. Ahmad Sudirman & Tim',
                'modules' => [
                    'Konsep Dasar Perpajakan Indonesia',
                    'PPh Pasal 21 dan Kewajiban Pemotongan',
                    'PPh Pasal 23/26 atas Jasa dan Bunga',
                    'PPN dan PPnBM',
                    'Penyusunan SPT Masa dan Tahunan',
                    'Teknik Penyelesaian Sengketa Pajak Ringan',
                ],
                'benefits' => [
                    'Sertifikat Brevet Pajak A resmi',
                    'Materi pembelajaran lengkap',
                    'Akses grup diskusi selamanya',
                    'Konsultasi pasca training',
                    'Simulasi soal ujian',
                ],
                'upcoming_dates' => [
                    ['date' => '10-14 Maret 2025', 'quota' => 25, 'registered' => 18],
                    ['date' => '16-20 Juni 2025', 'quota' => 25, 'registered' => 5],
                ],
            ],
            [
                'id' => 2,
                'slug' => 'brevet-pajak-b',
                'title' => 'Brevet Pajak B',
                'subtitle' => 'Sertifikasi Pajak Badan',
                'description' => 'Pelatihan lanjutan yang fokus pada perpajakan badan usaha, perhitungan PPh 25/29, penyusunan laporan keuangan fiskal, dan tax planning perusahaan.',
                'image' => 'https://images.unsplash.com/photo-1556761175-6726b3ff858f?w=800&q=80',
                'duration' => '5 Hari',
                'schedule' => 'April, Juli, Oktober',
                'price' => 'Rp 4.500.000',
                'discounted_price' => 'Rp 3.600.000',
                'format' => 'Online / Offline',
                'category' => 'Sertifikasi',
                'level' => 'Menengah',
                'instructor' => 'Dewi Kusuma, M.Si, Ak',
                'modules' => [
                    'PPh Badan dan Penghitungan Penghasilan Neto',
                    'Penyusunan Laporan Keuangan Fiskal',
                    'Rekonsiliasi Fiskal dan Komersial',
                    'PPh Pasal 25 dan 29',
                    'Pengurang dan Penambah Penghasilan',
                    'Tax Planning untuk Korporasi',
                ],
                'benefits' => [
                    'Sertifikat Brevet Pajak B resmi',
                    'Studi kasus perusahaan nyata',
                    'Template laporan fiskal',
                    'Networking dengan peserta lain',
                    'Akses video rekaman',
                ],
                'upcoming_dates' => [
                    ['date' => '7-11 April 2025', 'quota' => 20, 'registered' => 12],
                    ['date' => '21-25 Juli 2025', 'quota' => 20, 'registered' => 3],
                ],
            ],
            [
                'id' => 3,
                'slug' => 'brevet-pajak-c',
                'title' => 'Brevet Pajak C',
                'subtitle' => 'Sertifikasi Pajak Internasional',
                'description' => 'Program premium untuk memahami aspek perpajakan internasional, transfer pricing, tax treaty, dan pajak transaksi lintas batas. Untuk level manajerial.',
                'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=800&q=80',
                'duration' => '7 Hari',
                'schedule' => 'Mei, Agustus, November',
                'price' => 'Rp 7.500.000',
                'discounted_price' => 'Rp 6.000.000',
                'format' => 'Offline (Jakarta)',
                'category' => 'Sertifikasi',
                'level' => 'Lanjut',
                'instructor' => 'Prof. Bambang Wijaya, SE, Ak, BKP',
                'modules' => [
                    'Konsep Pajak Internasional dan Domicile',
                    'Double Taxation Avoidance Agreement (DTAA)',
                    'Transfer Pricing dan Dokumentasi',
                    'Anti Avoidance Rules (GAAR/SAAR)',
                    'Penggunaan Tax Treaty secara Optimal',
                    'Penyelesaian Sengketa Pajak Internasional',
                    'Mutual Agreement Procedure (MAP)',
                ],
                'benefits' => [
                    'Sertifikat Brevet Pajak C resmi',
                    'Materi dari praktisi internasional',
                    'Studi kasus multinasional',
                    'Akses ke jaringan eksklusif',
                    'Sesi mentoring privat',
                ],
                'upcoming_dates' => [
                    ['date' => '5-11 Mei 2025', 'quota' => 15, 'registered' => 8],
                    ['date' => '18-24 Agustus 2025', 'quota' => 15, 'registered' => 2],
                ],
            ],
            [
                'id' => 4,
                'slug' => 'tax-planning-intensif',
                'title' => 'Tax Planning Intensif',
                'subtitle' => 'Strategi Penghematan Pajak Legal',
                'description' => 'Workshop praktis tentang strategi perencanaan pajak yang efektif dan legal untuk individu maupun badan usaha. Belajar dari kasus nyata.',
                'image' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=800&q=80',
                'duration' => '2 Hari',
                'schedule' => 'Setiap Bulan',
                'price' => 'Rp 2.500.000',
                'discounted_price' => 'Rp 1.875.000',
                'format' => 'Online / Offline',
                'category' => 'Workshop',
                'level' => 'Menengah',
                'instructor' => 'Tim Ahli Pajak Kami',
                'modules' => [
                    'Prinsip Tax Planning yang Legal',
                    'Strategi untuk Individu dan Keluarga',
                    'Optimasi Struktur Bisnis',
                    'Timing Pengakuan Penghasilan',
                    'Pemanfaatan Insentif Pajak',
                    'Studi Kasus: Tax Planning Sukses',
                ],
                'benefits' => [
                    'Workbook strategi tax planning',
                    'Template perencanaan pajak',
                    'Konsultasi 30 menit pasca workshop',
                    'Sertifikat keikutsertaan',
                    'Diskon 10% jasa konsultasi',
                ],
                'upcoming_dates' => [
                    ['date' => '15-16 Februari 2025', 'quota' => 30, 'registered' => 22],
                    ['date' => '22-23 Maret 2025', 'quota' => 30, 'registered' => 8],
                ],
            ],
            [
                'id' => 5,
                'slug' => 'pajak-untuk-umkm',
                'title' => 'Pajak untuk UMKM',
                'subtitle' => 'Kepatuhan Pajak Bisnis Kecil',
                'description' => 'Pelatihan khusus untuk pelaku UMKM memahami kewajiban perpajakan dengan cara yang sederhana dan praktis. Fokus pada PP 23/2018.',
                'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&q=80',
                'duration' => '1 Hari',
                'schedule' => 'Bulanan',
                'price' => 'Rp 750.000',
                'discounted_price' => 'Rp 500.000',
                'format' => 'Online',
                'category' => 'Workshop',
                'level' => 'Dasar',
                'instructor' => 'Siti Rahayu, SE, Ak',
                'modules' => [
                    'Kewajiban Pajak UMKM',
                    'PP 23/2018: Pahami dan Manfaatkan',
                    'Pembukuan Sederhana untuk UMKM',
                    'e-Filing untuk Pelaku Usaha Kecil',
                    'Tanya Jawab Kasus UMKM',
                ],
                'benefits' => [
                    'Sertifikat keikutsertaan',
                    'Template pembukuan Excel',
                    'Panduan e-Filing langkah-demi-langkah',
                    'Akses video rekaman 30 hari',
                    'Grup konsultasi WhatsApp',
                ],
                'upcoming_dates' => [
                    ['date' => '22 Februari 2025', 'quota' => 50, 'registered' => 35],
                    ['date' => '29 Maret 2025', 'quota' => 50, 'registered' => 12],
                ],
            ],
            [
                'id' => 6,
                'slug' => 'efaktur-dan-ppn',
                'title' => 'e-Faktur dan PPN',
                'subtitle' => 'Pengelolaan Pajak Pertambahan Nilai',
                'description' => 'Pelatihan praktis penggunaan aplikasi e-Faktur dan pemahaman mendalam tentang ketentuan PPN terbaru untuk pengusaha kena pajak.',
                'image' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=800&q=80',
                'duration' => '2 Hari',
                'schedule' => 'Februari, Mei, Agustus, November',
                'price' => 'Rp 3.000.000',
                'discounted_price' => 'Rp 2.400.000',
                'format' => 'Online / Offline',
                'category' => 'Workshop',
                'level' => 'Menengah',
                'instructor' => 'Ratna Sari, SE, M.M',
                'modules' => [
                    'Konsep PPN dan Pengenaannya',
                    'PKP dan Non-PKP: Kriteria dan Kewajiban',
                    'Pembuatan Faktur Pajak Keluaran',
                    'Pengkreditan Faktur Pajak Masukan',
                    'Aplikasi e-Faktur 3.0',
                    'Pelaporan SPT Masa PPN',
                ],
                'benefits' => [
                    'Sertifikat keikutsertaan',
                    'Modul aplikasi e-Faktur',
                    'Simulasi pembuatan faktur',
                    'Template SPT PPN',
                    'Konsultasi teknis 60 hari',
                ],
                'upcoming_dates' => [
                    ['date' => '19-20 Februari 2025', 'quota' => 25, 'registered' => 20],
                    ['date' => '21-22 Mei 2025', 'quota' => 25, 'registered' => 5],
                ],
            ],
        ];

        $categories = [
            ['name' => 'Sertifikasi', 'count' => 3, 'icon' => 'fa-certificate'],
            ['name' => 'Workshop', 'count' => 3, 'icon' => 'fa-chalkboard-teacher'],
        ];

        $levels = [
            ['name' => 'Dasar', 'count' => 2],
            ['name' => 'Menengah', 'count' => 3],
            ['name' => 'Lanjut', 'count' => 1],
        ];

        $testimonials = [
            [
                'name' => 'Andi Wijaya',
                'company' => 'PT. Sukses Abadi',
                'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&q=80',
                'content' => 'Pelatihan Brevet Pajak di sini sangat praktis dan mudah dipahami. Instrukturnya berpengalaman dan materinya up-to-date.',
                'rating' => 5,
            ],
            [
                'name' => 'Maya Kusuma',
                'company' => 'Staff Pajak - Startup XYZ',
                'photo' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=200&q=80',
                'content' => 'Workshop Tax Planning sangat membantu saya memahami cara mengoptimalkan pajak perusahaan secara legal. Highly recommended!',
                'rating' => 5,
            ],
            [
                'name' => 'Budi Santoso',
                'company' => 'Pemilik UMKM',
                'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200&q=80',
                'content' => 'Akhirnya saya mengerti kewajiban pajak untuk UMKM. Penjelasannya sederhana dan langsung praktik. Terima kasih!',
                'rating' => 5,
            ],
        ];

        return view('web.trainings', compact(
            'trainings',
            'categories',
            'levels',
            'testimonials'
        ));
    }
}
