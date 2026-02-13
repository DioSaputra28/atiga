<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function index(): View
    {
        $activities = [
            [
                'id' => 1,
                'slug' => 'seminar-update-perpajakan-2025',
                'title' => 'Seminar Update Perpajakan 2025',
                'description' => 'Seminar tahunan membahas perubahan regulasi perpajakan yang berlaku di tahun 2025, termasuk implementasi UU HPP dan kebijakan terbaru DJP.',
                'image' => 'https://images.unsplash.com/photo-1544531585-9847b68c8c86?w=800&q=80',
                'date' => '2025-03-15',
                'time' => '09.00 - 16.00 WIB',
                'location' => 'Hotel Grand Sahid Jaya, Jakarta',
                'type' => 'Seminar',
                'status' => 'upcoming',
                'registration_open' => true,
                'registration_deadline' => '2025-03-10',
                'quota' => 200,
                'registered' => 127,
                'price' => 'Rp 500.000',
                'speakers' => [
                    [
                        'name' => 'Dr. H. John Sihar Simanjuntak',
                        'title' => 'Ketua Umum IKPI',
                        'photo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=200&q=80',
                    ],
                    [
                        'name' => 'Dewi Kusuma, M.Si, Ak',
                        'title' => 'Tax Partner - Konsultan Pajak Indonesia',
                        'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=200&q=80',
                    ],
                ],
                'agenda' => [
                    '08.30 - 09.00: Registrasi dan Coffee Break',
                    '09.00 - 09.30: Pembukaan dan Sambutan',
                    '09.30 - 11.00: Materi Utama: Update Regulasi Pajak 2025',
                    '11.00 - 11.15: Istirahat',
                    '11.15 - 12.30: Diskusi Kasus: Implementasi UU HPP',
                    '12.30 - 13.30: Makan Siang',
                    '13.30 - 15.00: Workshop: Strategi Tax Planning 2025',
                    '15.00 - 15.15: Istirahat',
                    '15.15 - 16.00: Tanya Jawab dan Penutup',
                ],
            ],
            [
                'id' => 2,
                'slug' => 'workshop-spt-tahunan',
                'title' => 'Workshop Lapor SPT Tahunan',
                'description' => 'Workshop praktis langkah demi langkah melaporkan SPT Tahunan menggunakan e-Filing. Dibimbing langsung oleh konsultan berpengalaman.',
                'image' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=800&q=80',
                'date' => '2025-02-28',
                'time' => '13.00 - 17.00 WIB',
                'location' => 'Kantor Konsultan Pajak Indonesia, Jakarta',
                'type' => 'Workshop',
                'status' => 'upcoming',
                'registration_open' => true,
                'registration_deadline' => '2025-02-25',
                'quota' => 50,
                'registered' => 38,
                'price' => 'Gratis',
                'speakers' => [
                    [
                        'name' => 'Siti Rahayu, SE, Ak',
                        'title' => 'Tax Manager',
                        'photo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=200&q=80',
                    ],
                ],
                'agenda' => [
                    '13.00 - 13.30: Registrasi',
                    '13.30 - 14.30: Pengenalan e-Filing DJP Online',
                    '14.30 - 15.00: Persiapan Dokumen SPT',
                    '15.00 - 15.15: Coffee Break',
                    '15.15 - 16.30: Praktik Langsung Mengisi SPT',
                    '16.30 - 17.00: Troubleshooting dan Tanya Jawab',
                ],
            ],
            [
                'id' => 3,
                'slug' => 'tax-talk-umkm',
                'title' => 'Tax Talk: Pajak untuk UMKM',
                'description' => 'Talkshow santai membahas kewajiban perpajakan bagi pelaku UMKM. Dengan bahasa yang sederhana dan contoh kasus nyata dari peserta.',
                'image' => 'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?w=800&q=80',
                'date' => '2025-02-20',
                'time' => '19.00 - 21.00 WIB',
                'location' => 'Zoom Meeting',
                'type' => 'Webinar',
                'status' => 'upcoming',
                'registration_open' => true,
                'registration_deadline' => '2025-02-19',
                'quota' => 300,
                'registered' => 215,
                'price' => 'Gratis',
                'speakers' => [
                    [
                        'name' => 'Bambang Wijaya, SE, Ak, BKP',
                        'title' => 'Senior Tax Advisor',
                        'photo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=200&q=80',
                    ],
                ],
                'agenda' => [
                    '19.00 - 19.15: Pembukaan',
                    '19.15 - 20.00: Materi: Kewajiban Pajak UMKM',
                    '20.00 - 20.45: Tanya Jawab Live',
                    '20.45 - 21.00: Penutup dan Kesimpulan',
                ],
            ],
            [
                'id' => 4,
                'slug' => 'konferensi-perpajakan-nasional',
                'title' => 'Konferensi Perpajakan Nasional 2024',
                'description' => 'Konferensi besar yang menghadirkan pembicara dari DJP, praktisi pajak, dan akademisi untuk membahas arah kebijakan perpajakan Indonesia.',
                'image' => 'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?w=800&q=80',
                'date' => '2024-11-20',
                'time' => '08.00 - 17.00 WIB',
                'location' => 'Jakarta Convention Center',
                'type' => 'Konferensi',
                'status' => 'completed',
                'registration_open' => false,
                'registration_deadline' => '2024-11-15',
                'quota' => 500,
                'registered' => 487,
                'price' => 'Rp 1.000.000',
                'speakers' => [
                    [
                        'name' => 'Pejabat DJP',
                        'title' => 'Direktur Jenderal Pajak',
                        'photo' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=200&q=80',
                    ],
                    [
                        'name' => 'Dr. Ahmad Sudirman',
                        'title' => 'Managing Partner',
                        'photo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=200&q=80',
                    ],
                ],
                'agenda' => [
                    '08.00 - 09.00: Registrasi',
                    '09.00 - 09.30: Pembukaan oleh MC',
                    '09.30 - 11.00: Keynote Speech: Arah Kebijakan Pajak 2025',
                    '11.00 - 12.30: Panel Discussion: Tax Reform',
                    '12.30 - 13.30: Makan Siang dan Networking',
                    '13.30 - 15.00: Breakout Sessions',
                    '15.00 - 15.30: Coffee Break',
                    '15.30 - 16.30: Plenary Session',
                    '16.30 - 17.00: Closing Ceremony',
                ],
            ],
            [
                'id' => 5,
                'slug' => 'pelatihan-brevet-batch-45',
                'title' => 'Pelatihan Brevet Pajak Batch 45',
                'description' => 'Pelatihan sertifikasi Brevet Pajak kelas ke-45 dengan peserta dari berbagai latar belakang profesional. Sukses meluluskan 40 peserta.',
                'image' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=800&q=80',
                'date' => '2024-09-10',
                'time' => '09.00 - 17.00 WIB',
                'location' => 'Training Center Konsultan Pajak Indonesia',
                'type' => 'Pelatihan',
                'status' => 'completed',
                'registration_open' => false,
                'registration_deadline' => '2024-09-05',
                'quota' => 40,
                'registered' => 40,
                'price' => 'Rp 3.500.000',
                'speakers' => [
                    [
                        'name' => 'Tim Instruktur Brevet',
                        'title' => 'Konsultan Pajak Bersertifikat',
                        'photo' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=200&q=80',
                    ],
                ],
                'agenda' => [
                    '09.00 - 10.30: Materi PPh 21',
                    '10.30 - 10.45: Istirahat',
                    '10.45 - 12.15: Materi PPh 23/26',
                    '12.15 - 13.15: Makan Siang',
                    '13.15 - 15.00: Materi PPN',
                    '15.00 - 15.15: Istirahat',
                    '15.15 - 16.45: Simulasi Ujian',
                    '16.45 - 17.00: Penutup',
                ],
            ],
            [
                'id' => 6,
                'slug' => 'csr-edukasi-pajak-sma',
                'title' => 'CSR: Edukasi Pajak di SMA',
                'description' => 'Program pengabdian masyarakat berupa edukasi perpajakan dasar bagi siswa SMA untuk meningkatkan kesadaran pajak sejak dini.',
                'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=800&q=80',
                'date' => '2024-08-15',
                'time' => '08.00 - 12.00 WIB',
                'location' => 'SMA Negeri 1 Jakarta',
                'type' => 'CSR',
                'status' => 'completed',
                'registration_open' => false,
                'registration_deadline' => null,
                'quota' => 100,
                'registered' => 95,
                'price' => 'Gratis',
                'speakers' => [
                    [
                        'name' => 'Ratna Sari, SE, M.M',
                        'title' => 'Tax Manager',
                        'photo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=200&q=80',
                    ],
                ],
                'agenda' => [
                    '08.00 - 08.30: Pembukaan oleh Kepala Sekolah',
                    '08.30 - 09.30: Pengenalan Konsep Pajak',
                    '09.30 - 10.00: Permainan Edukasi Pajak',
                    '10.00 - 10.30: Coffee Break',
                    '10.30 - 11.30: Simulasi Menjadi Wajib Pajak',
                    '11.30 - 12.00: Penutup dan Foto Bersama',
                ],
            ],
        ];

        $types = [
            ['name' => 'Seminar', 'count' => 1],
            ['name' => 'Workshop', 'count' => 1],
            ['name' => 'Webinar', 'count' => 1],
            ['name' => 'Konferensi', 'count' => 1],
            ['name' => 'Pelatihan', 'count' => 1],
            ['name' => 'CSR', 'count' => 1],
        ];

        $upcomingActivities = array_filter($activities, fn ($a) => $a['status'] === 'upcoming');
        $pastActivities = array_filter($activities, fn ($a) => $a['status'] === 'completed');

        $highlights = [
            [
                'number' => '150+',
                'label' => 'Kegiatan Terlaksana',
            ],
            [
                'number' => '10,000+',
                'label' => 'Total Peserta',
            ],
            [
                'number' => '50+',
                'label' => 'Pembicara Ahli',
            ],
            [
                'number' => '98%',
                'label' => 'Tingkat Kepuasan',
            ],
        ];

        return view('web.activities', compact(
            'activities',
            'upcomingActivities',
            'pastActivities',
            'types',
            'highlights'
        ));
    }
}
