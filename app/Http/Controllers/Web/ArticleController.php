<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ArticleController extends Controller
{
    private array $articles = [
        [
            'id' => 1,
            'slug' => 'strategi-efisiensi-pajak-2026',
            'title' => 'Strategi Efisiensi Pajak 2026 untuk Perusahaan Menengah',
            'excerpt' => 'Panduan strategis untuk mengoptimalkan beban pajak perusahaan pada tahun 2026 sesuai regulasi terbaru.',
            'content' => '<p>Pelaporan Surat Pemberitahuan (SPT) Tahunan merupakan kewajiban setiap Wajib Pajak di Indonesia. Tahun 2025 membawa beberapa pembaruan regulasi yang perlu diperhatikan oleh seluruh Wajib Pajak.</p>

<h3>Persiapan Dokumen</h3>
<p>Sebelum mulai melaporkan SPT, pastikan Anda telah menyiapkan dokumen-dokumen berikut:</p>
<ul>
<li>Bukti potong PPh 21 dari semua pemberi kerja</li>
<li>Bukti pembayaran PPh 25 (jika ada)</li>
<li>Dokumen pendapatan lainnya</li>
<li>Bukti pengurang penghasilan bruto</li>
</ul>

<h3>Tata Cara Pelaporan</h3>
<p>Anda dapat melaporkan SPT melalui:</p>
<ol>
<li>e-Filing melalui website DJP Online</li>
<li>Aplikasi e-Filing Mobile</li>
<li>Kantor Pelayanan Pajak terdekat</li>
</ol>

<p>Pastikan melaporkan sebelum batas waktu yang ditentukan untuk menghindari sanksi administrasi.</p>',
            'image' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=1200&q=80',
            'category' => 'Perpajakan',
            'tags' => ['SPT', 'PPh 21', 'Pelaporan Pajak', 'DJp Online'],
            'published_at' => '2025-02-10',
            'author' => [
                'name' => 'Tim Redaksi',
                'photo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=200&q=80',
                'bio' => 'Tim editorial Konsultan Pajak Indonesia',
            ],
            'read_time' => '5 menit',
        ],
        [
            'id' => 2,
            'slug' => 'memahami-tax-amnesty-jilid-ii',
            'title' => 'Memahami Tax Amnesty Jilid II: Peluang dan Risiko',
            'excerpt' => 'Analisis mendalam tentang program pengampunan pajak terbaru dan bagaimana memanfaatkannya dengan bijak.',
            'content' => '<p>Program Pengampunan Pajak atau Tax Amnesty kembali dihadirkan pemerintah sebagai upaya optimalisasi penerimaan negara. Program ini memberikan kesempatan kepada Wajib Pajak untuk mengungkapkan harta yang belum dilaporkan.</p>

<h3>Syarat Mengikuti Tax Amnesty</h3>
<ul>
<li>Tidak sedang dalam proses pemeriksaan</li>
<li>Tidak menjadi tersangka dalam perkara pidana di bidang perpajakan</li>
<li>Memiliki NPWP aktif</li>
<li>Mengungkapkan seluruh harta yang belum atau kurang diungkapkan</li>
</ul>

<h3>Tarif Tebusan</h3>
<p>Tarif tebusan yang berlaku:</p>
<ul>
<li>Repatriasi dan investasi di Indonesia: 11-14%</li>
<li>Tidak repatriasi tapi investasi di Indonesia: 14-18%</li>
<li>Tidak repatriasi dan tidak investasi: 18-20%</li>
</ul>

<h3>Pertimbangan Sebelum Mengikuti</h3>
<p>Sebelum memutuskan mengikuti program ini, perhatikan:</p>
<ol>
<li>Dampak terhadap struktur keuangan</li>
<li>Kewajiban investasi yang mengikat</li>
<li>Risiko pemeriksaan di masa depan</li>
</ol>',
            'image' => 'https://images.unsplash.com/photo-1554224154-26032ffc0d07?w=1200&q=80',
            'category' => 'Regulasi',
            'tags' => ['Tax Amnesty', 'Pengampunan Pajak', 'Harta Belum Dilaporkan'],
            'published_at' => '2025-02-08',
            'author' => [
                'name' => 'Budi Santoso, BKP',
                'photo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=200&q=80',
                'bio' => 'Konsultan Pajak dengan pengalaman 15 tahun di bidang perpajakan',
            ],
            'read_time' => '8 menit',
        ],
        [
            'id' => 3,
            'slug' => 'strategi-tax-planning-untuk-umkm',
            'title' => 'Strategi Tax Planning Efektif untuk UMKM',
            'excerpt' => 'Tips dan trik mengoptimalkan beban pajak untuk usaha kecil dan menengah sesuai ketentuan yang berlaku.',
            'content' => '<p>Usaha Mikro, Kecil, dan Menengah (UMKM) memiliki karakteristik khusus dalam aspek perpajakan. Dengan pemahaman yang tepat, UMKM dapat mengoptimalkan beban pajak secara legal.</p>

<h3>Pilihan Metode Perhitungan Pajak</h3>
<p>UMKM dapat memilih salah satu metode:</p>
<ul>
<li><strong>PP 23/2018:</strong> Tarif final 0.5% dari omzet</li>
<li><strong>Metode Norma:</strong> Menggunakan norma penghitungan penghasilan neto</li>
<li><strong>Pencatatan:</strong> Menghitung pajak berdasarkan pembukuan</li>
</ul>

<h3>Pengurang Penghasilan Bruto</h3>
<p>Biaya-biaya yang dapat dikurangkan:</p>
<ul>
<li>Biaya operasional usaha</li>
<li>Gaji dan tunjangan karyawan</li>
<li>Penyusutan aktiva tetap</li>
<li>Biaya pemasaran dan promosi</li>
</ul>

<h3>Tips Tax Planning UMKM</h3>
<ol>
<li>Pisahkan keuangan pribadi dan usaha</li>
<li>Lakukan pembukuan rutin</li>
<li>Manfaatkan insentif pajak yang tersedia</li>
<li>Konsultasikan dengan ahli pajak</li>
</ol>',
            'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1200&q=80',
            'category' => 'Bisnis',
            'tags' => ['UMKM', 'Tax Planning', 'PP 23/2018', 'Bisnis Kecil'],
            'published_at' => '2025-02-05',
            'author' => [
                'name' => 'Siti Rahayu, SE, Ak',
                'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=200&q=80',
                'bio' => 'Spesialisasi perpajakan UMKM dan startup',
            ],
            'read_time' => '6 menit',
        ],
        [
            'id' => 4,
            'slug' => 'pph-21-terbaru-2025',
            'title' => 'Update PPh 21 Terbaru Tahun 2025',
            'excerpt' => 'Perubahan tarif dan ketentuan PPh Pasal 21 yang berlaku efektif tahun 2025.',
            'content' => '<p>PPh Pasal 21 mengalami beberapa pembaruan regulasi yang berlaku sejak awal tahun 2025. Perubahan ini mempengaruhi perhitungan pajak penghasilan bagi karyawan dan pegawai.</p>

<h3>Perubahan Tarif Efektif</h3>
<p>Tarif PPh 21 terbaru mengacu pada UU HPP dengan struktur progresif:</p>
<ul>
<li>Rp0 - Rp60 juta: 5%</li>
<li>Rp60 juta - Rp250 juta: 15%</li>
<li>Rp250 juta - Rp500 juta: 25%</li>
<li>Rp500 juta - Rp5 miliar: 30%</li>
<li>Di atas Rp5 miliar: 35%</li>
</ul>

<h3>PTKP Terbaru</h3>
<p>Penghasilan Tidak Kena Pajak mengalami penyesuaian untuk mengakomodasi inflasi dan kebutuhan hidup.</p>

<h3>Dampak bagi Karyawan</h3>
<p>Karyawan perlu memahami perubahan ini untuk perencanaan keuangan yang lebih baik.</p>',
            'image' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=1200&q=80',
            'category' => 'PPh 21',
            'tags' => ['PPh 21', 'Gaji', 'Karyawan', 'Tarif Pajak'],
            'published_at' => '2025-02-12',
            'author' => [
                'name' => 'Tim Redaksi',
                'photo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=200&q=80',
                'bio' => 'Tim editorial Konsultan Pajak Indonesia',
            ],
            'read_time' => '4 menit',
        ],
        [
            'id' => 5,
            'slug' => 'cara-hitung-pajak-digital',
            'title' => 'Cara Menghitung Pajak Digital untuk Influencer',
            'excerpt' => 'Panduan lengkap perhitungan pajak bagi content creator, influencer, dan pekerja digital.',
            'content' => '<p>Era digital telah melahirkan profesi baru seperti influencer, content creator, dan pekerja remote. Profesi-profesi ini tetap memiliki kewajiban perpajakan yang perlu dipahami.</p>

<h3>Jenis Penghasilan Digital</h3>
<p>Penghasilan yang dikenai pajak meliputi:</p>
<ul>
<li>Pendapatan dari platform (YouTube, TikTok, Instagram)</li>
<li>Endorsement dan brand collaboration</li>
<li>Affiliate marketing</li>
<li>Penjualan produk digital</li>
<li>Donasi dan membership</li>
</ul>

<h3>Metode Perhitungan</h3>
<p>Bagi content creator dengan omzet di bawah Rp4.8 miliar, dapat menggunakan PP 23/2018 dengan tarif 0.5%.</p>

<h3>Kewajiban Pajak</h3>
<ul>
<li>Memiliki NPWP</li>
<li>Melaporkan SPT Tahunan</li>
<li>Membayar pajak terutang</li>
</ul>',
            'image' => 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=1200&q=80',
            'category' => 'Pajak Digital',
            'tags' => ['Influencer', 'Content Creator', 'Digital Economy', 'Pajak Digital'],
            'published_at' => '2025-02-11',
            'author' => [
                'name' => 'Andi Wijaya, SE',
                'photo' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=200&q=80',
                'bio' => 'Konsultan spesialis pajak ekonomi digital',
            ],
            'read_time' => '7 menit',
        ],
        [
            'id' => 6,
            'slug' => 'kesalahan-umum-pelaporan-pajak',
            'title' => '5 Kesalahan Umum dalam Pelaporan Pajak',
            'excerpt' => 'Hindari kesalahan-kesalahan yang sering terjadi saat melaporkan pajak untuk mencegah sanksi.',
            'content' => '<p>Banyak Wajib Pajak yang melakukan kesalahan dalam pelaporan pajak, baik disengaja maupun tidak. Kesalahan-kesalahan ini dapat berakibat pada sanksi administrasi maupun pidana.</p>

<h3>1. Keliru dalam Perhitungan</h3>
<p>Kesalahan menghitung penghasilan neto atau PTKP dapat mengakibatkan pajak terutang yang tidak tepat.</p>

<h3>2. Tidak Melampirkan Bukti Potong</h3>
<p>Bukti potong PPh 21, 23, dan lainnya harus dilampirkan sebagai dokumen pendukung.</p>

<h3>3. Melaporkan Terlambat</h3>
<p>Keterlambatan pelaporan SPT dikenakan sanksi administrasi berupa denda.</p>

<h3>4. Tidak Mengungkapkan Harta</h3>
<p>Harta yang belum atau kurang diungkapkan dapat menimbulkan masalah di kemudian hari.</p>

<h3>5. Salah Memilih Kategori Pekerjaan</h3>
<p>Kategori pekerjaan mempengaruhi besar PTKP dan pengurang penghasilan.</p>',
            'image' => 'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?w=1200&q=80',
            'category' => 'Kepatuhan',
            'tags' => ['Pelaporan Pajak', 'Kesalahan Pajak', 'Sanksi Pajak'],
            'published_at' => '2025-02-09',
            'author' => [
                'name' => 'Ratna Dewi, SE, M.M',
                'photo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=200&q=80',
                'bio' => 'Ahli kepatuhan pajak dengan pengalaman audit',
            ],
            'read_time' => '5 menit',
        ],
    ];

    public function index(): View
    {
        $articles = $this->articles;

        $categories = [
            ['name' => 'Perpajakan', 'count' => 12],
            ['name' => 'Regulasi', 'count' => 8],
            ['name' => 'Bisnis', 'count' => 6],
            ['name' => 'PPh 21', 'count' => 5],
            ['name' => 'Pajak Digital', 'count' => 4],
            ['name' => 'Kepatuhan', 'count' => 7],
        ];

        $popularTags = [
            'SPT', 'PPh 21', 'Pajak Badan', 'UMKM', 'e-Filing',
            'Tax Amnesty', 'PP 23/2018', 'DJp Online', 'Influencer',
        ];

        $featuredArticle = $this->articles[1];

        return view('web.articles.index', compact(
            'articles',
            'categories',
            'popularTags',
            'featuredArticle'
        ));
    }

    public function show(string $slug): View
    {
        $article = null;
        foreach ($this->articles as $item) {
            if ($item['slug'] === $slug) {
                $article = $item;
                break;
            }
        }

        if ($article === null) {
            abort(404);
        }

        $relatedArticles = array_filter($this->articles, function ($item) use ($article) {
            return $item['id'] !== $article['id'] && $item['category'] === $article['category'];
        });

        $relatedArticles = array_slice($relatedArticles, 0, 3);

        return view('web.articles.show', compact(
            'article',
            'relatedArticles'
        ));
    }
}
