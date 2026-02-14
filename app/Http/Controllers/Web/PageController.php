<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        $companyInfo = [
            'name' => 'PT. Konsultan Pajak Indonesia',
            'founded' => '2010',
            'headquarters' => 'Jakarta Selatan',
            'employees' => '50+',
            'clients' => '500+',
        ];

        $vision = 'Menjadi konsultan pajak terdepan di Indonesia yang memberikan solusi perpajakan berkualitas tinggi dengan integritas dan profesionalisme.';

        $mission = [
            'Memberikan layanan konsultasi pajak yang akurat dan tepat waktu',
            'Mendampingi klien dalam mencapai kepatuhan perpajakan yang optimal',
            'Mengembangkan SDM berkompeten di bidang perpajakan',
            'Menyediakan solusi tax planning yang efektif dan efisien',
            'Menjadi mitra strategis dalam pengembangan bisnis klien',
        ];

        $values = [
            [
                'icon' => 'fa-shield-alt',
                'title' => 'Integritas',
                'description' => 'Kami menjalankan praktik bisnis dengan jujur dan transparan',
            ],
            [
                'icon' => 'fa-award',
                'title' => 'Profesionalisme',
                'description' => 'Kualitas layanan adalah prioritas utama dalam setiap pekerjaan',
            ],
            [
                'icon' => 'fa-handshake',
                'title' => 'Kemitraan',
                'description' => 'Membangun hubungan jangka panjang dengan klien berbasis kepercayaan',
            ],
            [
                'icon' => 'fa-lightbulb',
                'title' => 'Inovasi',
                'description' => 'Terus beradaptasi dengan perkembangan regulasi dan teknologi',
            ],
        ];

        $team = [
            [
                'name' => 'Dr. Ahmad Sudirman',
                'position' => 'Founder & Managing Partner',
                'photo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400&q=80',
                'description' => 'Berpengalaman 25 tahun dalam konsultasi pajak korporasi',
            ],
            [
                'name' => 'Dewi Kusuma, M.Si, Ak',
                'position' => 'Tax Partner',
                'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&q=80',
                'description' => 'Ahli dalam perpajakan internasional dan transfer pricing',
            ],
            [
                'name' => 'Bambang Wijaya, SE, Ak, BKP',
                'position' => 'Senior Tax Advisor',
                'photo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&q=80',
                'description' => 'Spesialisasi dalam pajak badan dan tax planning strategis',
            ],
            [
                'name' => 'Ratna Sari, SE, M.M',
                'position' => 'Tax Manager',
                'photo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=400&q=80',
                'description' => 'Fokus pada pelatihan pajak dan pengembangan SDM',
            ],
        ];

        $milestones = [
            ['year' => '2010', 'event' => 'Pendirian perusahaan dengan 3 konsultan'],
            ['year' => '2013', 'event' => 'Ekspansi layanan ke seluruh Indonesia'],
            ['year' => '2016', 'event' => 'Mencapai 100 klien aktif'],
            ['year' => '2019', 'event' => 'Sertifikasi ISO 9001:2015'],
            ['year' => '2022', 'event' => 'Peluncuran platform digital konsultasi'],
            ['year' => '2025', 'event' => '500+ klien dan 50+ tim profesional'],
        ];

        return view('web.about', compact(
            'companyInfo',
            'vision',
            'mission',
            'values',
            'team',
            'milestones'
        ));
    }

    public function services(): View
    {
        $mainServices = [
            [
                'id' => 1,
                'icon' => 'fa-user-tie',
                'title' => 'Konsultasi Pajak Personal',
                'description' => 'Layanan konsultasi perpajakan untuk individu, termasuk perencanaan pajak, pelaporan SPT, dan penyelesaian sengketa pajak.',
                'features' => [
                    'Perencanaan pajak tahunan',
                    'Penyusunan SPT Tahunan PPh 21',
                    'Konsultasi harta dan warisan',
                    'Pengurangan pajak dan kredit',
                    'Penyelesaian ketidaksesuaian dengan DJP',
                ],
            ],
            [
                'id' => 2,
                'icon' => 'fa-building',
                'title' => 'Konsultasi Pajak Korporasi',
                'description' => 'Solusi perpajakan komprehensif untuk perusahaan dari berbagai skala dan industri.',
                'features' => [
                    'Tax planning dan restructuring',
                    'Penyusunan SPT Badan (PPh 25/29)',
                    'Pengelolaan PPh 21, 23, 26',
                    'Pembuatan e-Faktur dan pelaporan PPN',
                    'Transfer pricing documentation',
                ],
            ],
            [
                'id' => 3,
                'icon' => 'fa-file-contract',
                'title' => 'Pendampingan Pemeriksaan Pajak',
                'description' => 'Representasi profesional selama proses pemeriksaan pajak dan penyelesaian sengketa.',
                'features' => [
                    'Persiapan dokumen pemeriksaan',
                    'Pendampingan selama pemeriksaan lapangan',
                    'Penyusunan keberatan (objeksi)',
                    'Proses banding dan gugatan pajak',
                    'Negosiasi dengan fiskus',
                ],
            ],
            [
                'id' => 4,
                'icon' => 'fa-graduation-cap',
                'title' => 'Pelatihan dan Workshop',
                'description' => 'Program edukasi perpajakan untuk meningkatkan kompetensi tim Anda.',
                'features' => [
                    'In-house training perusahaan',
                    'Workshop perpajakan terbuka',
                    'Sertifikasi Brevet Pajak A/B/C',
                    'Konsultasi khusus per industri',
                    'Update regulasi berkala',
                ],
            ],
        ];

        $additionalServices = [
            [
                'icon' => 'fa-search',
                'title' => 'Tax Review',
                'description' => 'Audit internal kewajiban perpajakan untuk identifikasi risiko',
            ],
            [
                'icon' => 'fa-balance-scale',
                'title' => 'Kepatuhan Pajak',
                'description' => 'Pemetaan dan penanganan risiko kepatuhan perpajakan',
            ],
            [
                'icon' => 'fa-globe',
                'title' => 'Pajak Internasional',
                'description' => 'Konsultasi perpajakan lintas negara dan double taxation',
            ],
            [
                'icon' => 'fa-laptop-code',
                'title' => 'Otomatisasi Pajak',
                'description' => 'Implementasi sistem perpajakan digital untuk efisiensi',
            ],
        ];

        $processSteps = [
            [
                'number' => '01',
                'title' => 'Konsultasi Awal',
                'description' => 'Diskusi untuk memahami kebutuhan dan situasi perpajakan Anda',
            ],
            [
                'number' => '02',
                'title' => 'Analisis',
                'description' => 'Evaluasi mendalam terhadap dokumen dan kewajiban pajak',
            ],
            [
                'number' => '03',
                'title' => 'Solusi',
                'description' => 'Penyusunan strategi dan rekomendasi optimal',
            ],
            [
                'number' => '04',
                'title' => 'Implementasi',
                'description' => 'Eksekusi solusi dengan pendampingan penuh',
            ],
        ];

        return view('web.services', compact(
            'mainServices',
            'additionalServices',
            'processSteps'
        ));
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
