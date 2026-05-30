<?php

namespace Database\Seeders;

use App\Models\KampusMitra;
use App\Models\Beasiswa;
use Illuminate\Database\Seeder;

class BeasiswaTerbaruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $campusesData = [
            [
                'nama_kampus' => 'STKIP Sinar Cendekia',
                'deskripsi' => 'Sekolah Tinggi Keguruan dan Ilmu Pendidikan yang membuka kesempatan bagi lulusan SMA/SMK/MA untuk melanjutkan pendidikan melalui berbagai jalur bantuan biaya.',
                'website' => 'stkipsinarcendekia.ac.id',
                'kontak' => 'stkipsinarcendekia.ac.id/beasiswa',
                'alamat' => 'Indonesia',
                'is_active' => true,
            ],
            [
                'nama_kampus' => 'Universitas Teknologi Sumbawa',
                'deskripsi' => 'Universitas yang menyediakan bantuan beasiswa untuk mendukung pendidikan jenjang sarjana dan pascasarjana. Hingga 2024 tercatat 2.469 mahasiswa penerima beasiswa sejak 2017. Memiliki 32 program studi di 8 fakultas.',
                'website' => 'uts.ac.id',
                'kontak' => 'uts.ac.id/penerimaan-beasiswa',
                'alamat' => 'Sumbawa, Nusa Tenggara Barat',
                'is_active' => true,
            ],
            [
                'nama_kampus' => 'STT Terpadu Nurul Fikri',
                'deskripsi' => 'Sekolah Tinggi Teknologi berbasis nilai Islam yang membuka Program Beasiswa Tahun Akademik 2026/2027 dengan tiga jalur pilihan.',
                'website' => 'nurulfikri.ac.id',
                'kontak' => 'nurulfikri.ac.id/beastudi',
                'alamat' => 'Depok, Jawa Barat',
                'is_active' => true,
            ],
            [
                'nama_kampus' => 'Politeknik Praktisi Bandung',
                'deskripsi' => 'Politeknik yang berfokus pada kompetensi digital di bidang bisnis digital, akuntansi, perpajakan, dan teknologi informasi.',
                'website' => 'praktisi.ac.id',
                'kontak' => 'praktisi.ac.id',
                'alamat' => 'Jalan Ir. H. Djuanda No. 294A, Bandung, Jawa Barat',
                'is_active' => true,
            ],
            [
                'nama_kampus' => 'Universitas Logistik dan Bisnis Internasional',
                'deskripsi' => 'Kampus BUMN di bawah PT Pos Indonesia yang menyediakan jalur beasiswa APERTI BUMN dan jalur ikatan dinas. Pada 2026 menyediakan 53 kuota beasiswa.',
                'website' => 'ulbi.ac.id',
                'kontak' => 'admission.ulbi.ac.id',
                'alamat' => 'Bandung, Jawa Barat',
                'is_active' => true,
            ],
            [
                'nama_kampus' => 'Telkom University',
                'deskripsi' => 'Salah satu PTS terbaik di Indonesia dengan 7 fakultas dan 82 program studi dari jenjang Diploma hingga Doktoral. Kampus tersebar di Bandung, Jakarta, Surabaya, dan Purwokerto.',
                'website' => 'telkomuniversity.ac.id',
                'kontak' => 'smb.telkomuniversity.ac.id',
                'alamat' => 'Bandung, Jawa Barat',
                'is_active' => true,
            ],
            [
                'nama_kampus' => 'Universitas Widyatama',
                'deskripsi' => 'Universitas swasta yang membuka jalur KIP Kuliah dengan ketentuan khusus, menjaring calon mahasiswa berprestasi yang membutuhkan dukungan finansial.',
                'website' => 'widyatama.ac.id',
                'kontak' => 'pmb.widyatama.ac.id',
                'alamat' => 'Bandung, Jawa Barat',
                'is_active' => true,
            ]
        ];

        $campusCountInserted = 0;
        $campusCountExisting = 0;
        $campusMap = [];

        foreach ($campusesData as $cData) {
            $campus = KampusMitra::where('nama_kampus', $cData['nama_kampus'])->first();
            if ($campus) {
                $campusCountExisting++;
            } else {
                $campus = KampusMitra::create($cData);
                $campusCountInserted++;
            }
            $campusMap[$cData['nama_kampus']] = $campus->id;
        }

        $beasiswasData = [
            [
                'kampus' => 'STKIP Sinar Cendekia',
                'nama_beasiswa' => 'KIP Kuliah STKIP Sinar Cendekia',
                'jenis' => 'full_funding',
                'deskripsi' => 'Program KIP Kuliah ditujukan bagi calon mahasiswa yang memiliki potensi akademik namun terkendala secara ekonomi. Dibuktikan dengan dokumen SKTM, KIP, atau PIP. Seleksi meliputi tes akademik dan wawancara secara online.',
                'persyaratan' => [
                    'Lulusan SMA/SMK/MA tahun 2024, 2025, atau 2026',
                    'Penghasilan gabungan orang tua di bawah Rp4.000.000/bulan',
                    'Memiliki dokumen SKTM, KIP, atau PIP',
                    'Mengikuti tes akademik online',
                    'Mengikuti wawancara online'
                ],
                'kuota' => 50,
                'deadline' => '2026-09-30',
                'status' => 'aktif',
            ],
            [
                'kampus' => 'STKIP Sinar Cendekia',
                'nama_beasiswa' => 'Beasiswa Internal Yayasan STKIP Sinar Cendekia',
                'jenis' => 'partial_funding',
                'deskripsi' => "Program dukungan pembiayaan langsung dari yayasan kampus STKIP Sinar Cendekia. Tersedia jalur khusus tanpa tes bagi pendaftar dengan hafalan Al-Qur'an minimal 3 juz.",
                'persyaratan' => [
                    'Lulusan SMA/SMK/MA tahun 2024, 2025, atau 2026',
                    'Mengikuti tes akademik dan wawancara online',
                    "Jalur khusus: memiliki hafalan Al-Qur'an minimal 3 juz (bebas tes akademik)"
                ],
                'kuota' => 30,
                'deadline' => '2026-09-30',
                'status' => 'aktif',
            ],
            [
                'kampus' => 'Universitas Teknologi Sumbawa',
                'nama_beasiswa' => 'KIP Kuliah UTS',
                'jenis' => 'full_funding',
                'deskripsi' => 'Bantuan beasiswa KIP Kuliah bagi calon mahasiswa dari keluarga kurang mampu yang berprestasi untuk jenjang sarjana maupun pascasarjana di Universitas Teknologi Sumbawa. UTS memiliki 32 program studi di 8 fakultas yang mencakup bidang saintek hingga sosial humaniora.',
                'persyaratan' => [
                    'Lulusan SMA/SMK/MA tahun 2024, 2025, atau 2026',
                    'Berasal dari keluarga kurang mampu (ekonomi terbatas)',
                    'Memiliki prestasi akademik yang baik',
                    'Memiliki akun KIP Kuliah aktif dari Kemdikbud'
                ],
                'kuota' => 40,
                'deadline' => '2026-09-30',
                'status' => 'aktif',
            ],
            [
                'kampus' => 'Universitas Teknologi Sumbawa',
                'nama_beasiswa' => 'Beasiswa Yayasan UTS',
                'jenis' => 'partial_funding',
                'deskripsi' => 'Dukungan pembiayaan internal kampus dari yayasan Universitas Teknologi Sumbawa bagi mahasiswa berprestasi yang membutuhkan keringanan biaya pendidikan.',
                'persyaratan' => [
                    'Lulusan SMA/SMK/MA tahun 2024, 2025, atau 2026',
                    'Memiliki prestasi akademik atau non-akademik',
                    'Mengikuti proses seleksi yang ditetapkan UTS'
                ],
                'kuota' => 35,
                'deadline' => '2026-09-30',
                'status' => 'aktif',
            ],
            [
                'kampus' => 'STT Terpadu Nurul Fikri',
                'nama_beasiswa' => 'KIP Kuliah STT Nurul Fikri',
                'jenis' => 'full_funding',
                'deskripsi' => 'Beasiswa KIP Kuliah memberikan pendidikan 100% gratis beserta uang saku bagi calon mahasiswa yang terdaftar di DTKS dan memiliki akun KIP Kuliah aktif. Seluruh jalur memerlukan tes TPA dan wawancara sebagai tahapan seleksi.',
                'persyaratan' => [
                    'Lulusan SMA/SMK/MA tahun 2024, 2025, atau 2026',
                    'Terdaftar di DTKS (Data Terpadu Kesejahteraan Sosial)',
                    'Memiliki akun KIP Kuliah aktif dari Kemdikbud',
                    'Mengikuti tes TPA',
                    'Mengikuti wawancara seleksi'
                ],
                'kuota' => 30,
                'deadline' => '2026-09-30',
                'status' => 'aktif',
            ],
            [
                'kampus' => 'STT Terpadu Nurul Fikri',
                'nama_beasiswa' => 'Beasiswa Tahfidz STT Nurul Fikri',
                'jenis' => 'full_funding',
                'deskripsi' => "Beasiswa Tahfidz (Beasiswa Yayasan) tersedia bagi pendaftar yang memiliki hafalan Al-Qur'an minimal 5 juz dengan sertifikat resmi. Merupakan jalur beasiswa penuh dari yayasan STT Terpadu Nurul Fikri TA 2026/2027.",
                'persyaratan' => [
                    'Lulusan SMA/SMK/MA tahun 2024, 2025, atau 2026',
                    "Memiliki hafalan Al-Qur'an minimal 5 juz",
                    'Memiliki sertifikat tahfidz resmi',
                    'Mengikuti tes TPA',
                    'Mengikuti wawancara seleksi'
                ],
                'kuota' => 20,
                'deadline' => '2026-09-30',
                'status' => 'aktif',
            ],
            [
                'kampus' => 'STT Terpadu Nurul Fikri',
                'nama_beasiswa' => 'Beasiswa Prestasi Parsial STT Nurul Fikri',
                'jenis' => 'partial_funding',
                'deskripsi' => 'Beasiswa Prestasi (Parsial) diberikan kepada calon mahasiswa dengan nilai rapor rata-rata minimal 75 dan/atau memiliki sertifikat lomba akademik maupun non-akademik. Berlaku untuk TA 2026/2027.',
                'persyaratan' => [
                    'Lulusan SMA/SMK/MA tahun 2024, 2025, atau 2026',
                    'Nilai rapor rata-rata minimal 75',
                    'Atau memiliki sertifikat lomba akademik/non-akademik',
                    'Mengikuti tes TPA',
                    'Mengikuti wawancara seleksi'
                ],
                'kuota' => 50,
                'deadline' => '2026-09-30',
                'status' => 'aktif',
            ],
            [
                'kampus' => 'Politeknik Praktisi Bandung',
                'nama_beasiswa' => 'KIP Kuliah Politeknik Praktisi Bandung',
                'jenis' => 'full_funding',
                'deskripsi' => 'Jalur KIP Kuliah menanggung biaya pendidikan penuh bagi mahasiswa dari keluarga kurang mampu yang berprestasi di Politeknik Praktisi Bandung. Kampus berfokus pada kompetensi digital: bisnis digital, akuntansi, perpajakan, dan teknologi informasi.',
                'persyaratan' => [
                    'Lulusan SMA/SMK/MA tahun 2024, 2025, atau 2026',
                    'Berasal dari keluarga kurang mampu',
                    'Memiliki prestasi akademik yang baik',
                    'Memiliki akun KIP Kuliah aktif dari Kemdikbud'
                ],
                'kuota' => 25,
                'deadline' => '2026-09-30',
                'status' => 'aktif',
            ],
            [
                'kampus' => 'Politeknik Praktisi Bandung',
                'nama_beasiswa' => 'Beasiswa Yayasan Politeknik Praktisi Bandung',
                'jenis' => 'partial_funding',
                'deskripsi' => 'Beasiswa Yayasan memberikan dukungan pembiayaan yang bersumber dari dana internal institusi Politeknik Praktisi Bandung bagi calon mahasiswa berprestasi.',
                'persyaratan' => [
                    'Lulusan SMA/SMK/MA tahun 2024, 2025, atau 2026',
                    'Memiliki prestasi akademik atau non-akademik',
                    'Mengikuti proses seleksi yang ditetapkan kampus'
                ],
                'kuota' => 20,
                'deadline' => '2026-09-30',
                'status' => 'aktif',
            ],
            [
                'kampus' => 'Politeknik Praktisi Bandung',
                'nama_beasiswa' => 'Program Potongan Biaya 50% Politeknik Praktisi Bandung',
                'jenis' => 'partial_funding',
                'deskripsi' => 'Program Potongan Biaya 50% hadir sebagai opsi bagi pendaftar yang tidak memenuhi syarat beasiswa penuh namun tetap membutuhkan keringanan biaya di Politeknik Praktisi Bandung.',
                'persyaratan' => [
                    'Lulusan SMA/SMK/MA tahun 2024, 2025, atau 2026',
                    'Tidak memenuhi syarat beasiswa penuh',
                    'Membutuhkan keringanan biaya pendidikan',
                    'Mengikuti proses seleksi yang ditetapkan kampus'
                ],
                'kuota' => 40,
                'deadline' => '2026-09-30',
                'status' => 'aktif',
            ],
            [
                'kampus' => 'Universitas Logistik dan Bisnis Internasional',
                'nama_beasiswa' => 'Beasiswa APERTI BUMN Penuh ULBI',
                'jenis' => 'full_funding',
                'deskripsi' => 'Beasiswa APERTI BUMN Full Scholarship mencakup pembebasan 100% Sumbangan Pengembangan Institusi (SPI) hingga lulus. Pada tahun 2026 tersedia 3 kuota beasiswa penuh bagi calon mahasiswa berprestasi dari seluruh Indonesia. ULBI adalah kampus BUMN di bawah PT Pos Indonesia.',
                'persyaratan' => [
                    'Lulusan SMA/SMK/MA tahun 2024, 2025, atau 2026',
                    'Memiliki prestasi akademik yang sangat baik',
                    'Mengikuti seleksi APERTI BUMN',
                    'Bersedia mengikuti seluruh tahapan seleksi'
                ],
                'kuota' => 3,
                'deadline' => '2026-09-30',
                'status' => 'aktif',
            ],
            [
                'kampus' => 'Universitas Logistik dan Bisnis Internasional',
                'nama_beasiswa' => 'Beasiswa APERTI BUMN Parsial ULBI',
                'jenis' => 'partial_funding',
                'deskripsi' => 'Beasiswa APERTI BUMN Parsial mencakup bebas biaya DPP dan gratis SPP 1 semester terakhir. Tersedia 50 kuota pada tahun 2026 bagi calon mahasiswa berprestasi dari seluruh Indonesia.',
                'persyaratan' => [
                    'Lulusan SMA/SMK/MA tahun 2024, 2025, atau 2026',
                    'Memiliki prestasi akademik yang baik',
                    'Mengikuti seleksi APERTI BUMN',
                    'Bersedia mengikuti seluruh tahapan seleksi'
                ],
                'kuota' => 50,
                'deadline' => '2026-09-30',
                'status' => 'aktif',
            ],
            [
                'kampus' => 'Universitas Logistik dan Bisnis Internasional',
                'nama_beasiswa' => 'Jalur Ikatan Dinas PT Pos Indonesia (ULBI)',
                'jenis' => 'full_funding',
                'deskripsi' => 'Jalur Reguler Ikatan Dinas membuka peluang beasiswa penuh bagi pendaftar yang lolos seleksi ikatan dinas PT Pos Indonesia. Peserta yang gugur tetap diberikan kesempatan kuliah di ULBI jalur reguler dengan bebas biaya pendaftaran.',
                'persyaratan' => [
                    'Lulusan SMA/SMK/MA tahun 2024, 2025, atau 2026',
                    'Mengikuti seleksi ikatan dinas PT Pos Indonesia',
                    'Memenuhi syarat fisik dan administratif PT Pos Indonesia',
                    'Bersedia ditempatkan sesuai kebutuhan PT Pos Indonesia'
                ],
                'kuota' => 15,
                'deadline' => '2026-09-30',
                'status' => 'aktif',
            ],
            [
                'kampus' => 'Telkom University',
                'nama_beasiswa' => 'Beasiswa Subsidi Kampus 50% Telkom University',
                'jenis' => 'partial_funding',
                'deskripsi' => 'Program beasiswa dari Telkom University yang memberikan potongan biaya kuliah sebesar 50% yang langsung ditanggung kampus. Terbuka bagi lulusan SMA/SMK/MA 2024, 2025, dan 2026 dengan nilai rapor minimal 75. Menerima sertifikat prestasi akademik maupun non-akademik sebagai nilai tambah.',
                'persyaratan' => [
                    'Lulusan SMA/SMK/MA tahun 2024, 2025, atau 2026',
                    'Nilai rapor rata-rata minimal 75',
                    'Sertifikat prestasi akademik atau non-akademik (nilai tambah)',
                    'Mengikuti proses seleksi Telkom University'
                ],
                'kuota' => 100,
                'deadline' => '2026-09-30',
                'status' => 'aktif',
            ],
            [
                'kampus' => 'Telkom University',
                'nama_beasiswa' => 'Beasiswa Pintar Telkom University',
                'jenis' => 'partial_funding',
                'deskripsi' => 'Beasiswa Pintar dari Telkom University berupa potongan biaya pendidikan tahun pertama yang mencakup 100% biaya UP3, 100% biaya SDP2, atau keduanya sekaligus. Terbuka bagi lulusan SMA/SMK/MA 2024, 2025, dan 2026.',
                'persyaratan' => [
                    'Lulusan SMA/SMK/MA tahun 2024, 2025, atau 2026',
                    'Nilai rapor rata-rata minimal 75',
                    'Sertifikat prestasi akademik atau non-akademik (nilai tambah)',
                    'Mengikuti seleksi beasiswa Telkom University'
                ],
                'kuota' => 80,
                'deadline' => '2026-09-30',
                'status' => 'aktif',
            ],
            [
                'kampus' => 'Universitas Widyatama',
                'nama_beasiswa' => 'KIP Kuliah Universitas Widyatama',
                'jenis' => 'full_funding',
                'deskripsi' => 'Jalur KIP Kuliah Universitas Widyatama bagi calon mahasiswa baru yang memiliki keterbatasan ekonomi namun berprestasi. Keunikannya: pendaftar wajib melampirkan minimal 3 sertifikat prestasi tingkat kota atau lebih. Beasiswa mencakup pembebasan biaya kuliah penuh sesuai ketentuan KIP Kuliah pemerintah.',
                'persyaratan' => [
                    'Lulusan SMA/SMK/MA tahun 2024, 2025, atau 2026',
                    'Memiliki keterbatasan ekonomi',
                    'Melampirkan minimal 3 sertifikat prestasi tingkat kota atau lebih',
                    'Prestasi dapat akademik maupun non-akademik',
                    'Memiliki akun KIP Kuliah aktif dari Kemdikbud'
                ],
                'kuota' => 45,
                'deadline' => '2026-09-30',
                'status' => 'aktif',
            ]
        ];

        $beasiswaCount = 0;
        foreach ($beasiswasData as $bData) {
            $campusId = $campusMap[$bData['kampus']] ?? null;
            if ($campusId) {
                Beasiswa::create([
                    'kampus_mitra_id' => $campusId,
                    'nama_beasiswa' => $bData['nama_beasiswa'],
                    'deskripsi' => $bData['deskripsi'],
                    'jenis' => $bData['jenis'],
                    'persyaratan' => $bData['persyaratan'],
                    'kuota' => $bData['kuota'],
                    'deadline' => $bData['deadline'],
                    'status' => $bData['status'],
                ]);
                $beasiswaCount++;
            }
        }

        $this->command->info("Kampus Mitra: {$campusCountInserted} baru ditambahkan, {$campusCountExisting} sudah ada.");
        $this->command->info("Beasiswa: {$beasiswaCount} baru berhasil dimasukkan.");
    }
}
