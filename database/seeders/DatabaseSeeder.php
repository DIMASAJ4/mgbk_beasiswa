<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\KampusMitra;
use App\Models\Beasiswa;
use App\Models\DataSiswa;
use App\Models\Rekomendasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run Role and Permission seeder first
        $this->call(RoleAndPermissionSeeder::class);

        // 1. Create Admin
        $admin = User::create([
            'name' => 'Admin MGBK',
            'email' => 'admin@mgbk.mail',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'no_hp' => '081122334455',
        ]);
        $admin->assignRole('Admin');

        // 2. Create 3 Guru BK
        $bk1 = User::create([
            'name' => 'Siti Aminah, M.Pd',
            'email' => 'sitiaminah@mgbk.mail',
            'password' => bcrypt('password'),
            'role' => 'guru_bk',
            'nip' => '198502122010122003',
            'sekolah' => 'SMKN 2 Bandung',
            'no_hp' => '081234567890',
        ]);
        $bk1->assignRole('Guru BK');

        $bk2 = User::create([
            'name' => 'Budi Santoso, S.Pd',
            'email' => 'budisantoso@mgbk.mail',
            'password' => bcrypt('password'),
            'role' => 'guru_bk',
            'nip' => '197804152005011002',
            'sekolah' => 'SMA Negeri 1 Jakarta',
            'no_hp' => '081234567891',
        ]);
        $bk2->assignRole('Guru BK');

        $bk3 = User::create([
            'name' => 'Dewi Lestari, S.Psi',
            'email' => 'dewilestari@mgbk.mail',
            'password' => bcrypt('password'),
            'role' => 'guru_bk',
            'nip' => '198911022018032001',
            'sekolah' => 'SMA BPK Penabur',
            'no_hp' => '081234567892',
        ]);
        $bk3->assignRole('Guru BK');

        // 3. Create 10 Siswa
        $siswaData = [
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'siswa@mgbk.mail',
                'kelas' => 'XII IPA 1',
                'sekolah' => 'SMA Negeri 1 Jakarta',
                'no_hp' => '081234567801',
                'nisn' => '007248192',
                'nilai' => 88.50,
                'ekonomi' => 'kurang_mampu',
                'prestasi' => 'Juara 1 Lomba Karya Tulis Ilmiah Nasional',
                'minat' => ['Teknik Informatika', 'Manajemen'],
            ],
            [
                'name' => 'Aditya Pratama',
                'email' => 'aditya@mgbk.mail',
                'kelas' => 'XII IPS 2',
                'sekolah' => 'SMA Negeri 1 Jakarta',
                'no_hp' => '081234567802',
                'nisn' => '008234891',
                'nilai' => 87.20,
                'ekonomi' => 'kurang_mampu',
                'prestasi' => 'Juara 2 Debat Bahasa Inggris Provinsi',
                'minat' => ['Hukum', 'Psikologi'],
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti.siswa@mgbk.mail',
                'kelas' => 'XII Akuntansi 2',
                'sekolah' => 'SMKN 2 Bandung',
                'no_hp' => '081234567803',
                'nisn' => '007119283',
                'nilai' => 90.15,
                'ekonomi' => 'tidak_mampu',
                'prestasi' => 'Peringkat 1 Paralel Sekolah',
                'minat' => ['Manajemen', 'Hukum'],
            ],
            [
                'name' => 'Rizky Ramadhan',
                'email' => 'rizky@mgbk.mail',
                'kelas' => 'XII IPA 3',
                'sekolah' => 'SMA BPK Penabur',
                'no_hp' => '081234567804',
                'nisn' => '008772834',
                'nilai' => 94.80,
                'ekonomi' => 'mampu',
                'prestasi' => 'Medali Emas Olimpiade Fisika Nasional',
                'minat' => ['Teknik Informatika', 'Kedokteran'],
            ],
            [
                'name' => 'Larasati Putri',
                'email' => 'larasati@mgbk.mail',
                'kelas' => 'XII IPA 2',
                'sekolah' => 'SMA Negeri 8 Jakarta',
                'no_hp' => '081234567805',
                'nisn' => '007662918',
                'nilai' => 89.90,
                'ekonomi' => 'kurang_mampu',
                'prestasi' => 'Juara 1 Lomba Storytelling Kota',
                'minat' => ['Kedokteran', 'Psikologi'],
            ],
            [
                'name' => 'Ahmad Subarkah',
                'email' => 'subarkah@mgbk.mail',
                'kelas' => 'XII IPS 1',
                'sekolah' => 'SMA Negeri 1 Jakarta',
                'no_hp' => '081234567806',
                'nisn' => '007883921',
                'nilai' => 85.40,
                'ekonomi' => 'tidak_mampu',
                'prestasi' => 'Juara 3 Pencak Silat Tingkat Provinsi',
                'minat' => ['Hukum', 'Seni Rupa'],
            ],
            [
                'name' => 'Bunga Nabilla',
                'email' => 'bunga@mgbk.mail',
                'kelas' => 'XII Perhotelan 1',
                'sekolah' => 'SMKN 2 Bandung',
                'no_hp' => '081234567807',
                'nisn' => '007994827',
                'nilai' => 86.80,
                'ekonomi' => 'kurang_mampu',
                'prestasi' => 'Juara 1 Lomba Cooking Competition regional',
                'minat' => ['Manajemen', 'Seni Rupa'],
            ],
            [
                'name' => 'Dandi Pratama',
                'email' => 'dandi@mgbk.mail',
                'kelas' => 'XII IPA 4',
                'sekolah' => 'SMA BPK Penabur',
                'no_hp' => '081234567808',
                'nisn' => '008991823',
                'nilai' => 83.50,
                'ekonomi' => 'mampu',
                'prestasi' => 'Anggota Paskibra Kota',
                'minat' => ['Teknik Informatika', 'Hukum'],
            ],
            [
                'name' => 'Eka Saputra',
                'email' => 'eka@mgbk.mail',
                'kelas' => 'XII IPS 3',
                'sekolah' => 'SMA Negeri 8 Jakarta',
                'no_hp' => '081234567809',
                'nisn' => '007553920',
                'nilai' => 91.20,
                'ekonomi' => 'tidak_mampu',
                'prestasi' => 'Juara 1 Lomba Desain Poster Provinsi',
                'minat' => ['Seni Rupa', 'Teknik Informatika'],
            ],
            [
                'name' => 'Rian Hidayat',
                'email' => 'rian@mgbk.mail',
                'kelas' => 'XII IPA 1',
                'sekolah' => 'SMA Negeri 1 Jakarta',
                'no_hp' => '081234567810',
                'nisn' => '007663719',
                'nilai' => 89.00,
                'ekonomi' => 'kurang_mampu',
                'prestasi' => 'Juara 2 Lomba Pidato Bahasa Arab',
                'minat' => ['Hukum', 'Manajemen'],
            ],
        ];

        $siswaModels = [];
        $dataSiswaModels = [];

        foreach ($siswaData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt('password'),
                'role' => 'siswa',
                'kelas' => $data['kelas'],
                'sekolah' => $data['sekolah'],
                'no_hp' => $data['no_hp'],
                'nisn' => $data['nisn'],
            ]);
            $user->assignRole('Siswa');
            $siswaModels[] = $user;

            $dataSiswa = DataSiswa::create([
                'user_id' => $user->id,
                'nilai_rata' => $data['nilai'],
                'prestasi' => $data['prestasi'],
                'kondisi_ekonomi' => $data['ekonomi'],
                'minat_jurusan' => $data['minat'],
                'is_verified' => true,
            ]);
            $dataSiswaModels[] = $dataSiswa;
        }

        // 4. Create 5 Kampus Mitra
        $kampusData = [
            [
                'nama_kampus' => 'Universitas Indonesia',
                'logo' => 'ui.png',
                'deskripsi' => 'Universitas Indonesia (UI) adalah kampus modern, komprehensif, terbuka, multi-budaya, dan humanis yang mencakup disiplin ilmu yang luas.',
                'website' => 'https://ui.ac.id',
                'kontak' => '(021) 7867222',
                'alamat' => 'Kampus UI Depok, Jawa Barat, 16424',
            ],
            [
                'nama_kampus' => 'Institut Teknologi Bandung',
                'logo' => 'itb.png',
                'deskripsi' => 'Institut Teknologi Bandung (ITB) adalah sekolah tinggi teknik pertama di Indonesia yang berorientasi pada pengembangan sains dan teknologi.',
                'website' => 'https://itb.ac.id',
                'kontak' => '(022) 2500935',
                'alamat' => 'Jl. Ganesha No.10, Lb. Siliwangi, Bandung, Jawa Barat 40132',
            ],
            [
                'nama_kampus' => 'Universitas Gadjah Mada',
                'logo' => 'ugm.png',
                'deskripsi' => 'Universitas Gadjah Mada (UGM) merupakan universitas negeri tertua dan terbesar di Indonesia yang berkomitmen pada pendidikan inklusif berkualitas.',
                'website' => 'https://ugm.ac.id',
                'kontak' => '(0274) 6492599',
                'alamat' => 'Bulaksumur, Caturtunggal, Depok, Sleman, DI Yogyakarta 55281',
            ],
            [
                'nama_kampus' => 'Telkom University',
                'logo' => 'telkom.png',
                'deskripsi' => 'Telkom University adalah perguruan tinggi swasta terbaik di Indonesia yang unggul dalam bidang teknologi informasi, telekomunikasi, dan industri kreatif.',
                'website' => 'https://telkomuniversity.ac.id',
                'kontak' => '(022) 7564108',
                'alamat' => 'Jl. Telekomunikasi No. 1, Terusan Buahbatu, Bandung, Jawa Barat 40257',
            ],
            [
                'nama_kampus' => 'Universitas Padjadjaran',
                'logo' => 'unpad.png',
                'deskripsi' => 'Universitas Padjadjaran (Unpad) adalah universitas negeri dengan reputasi tinggi di bidang hukum, kedokteran, dan ilmu sosial-humaniora.',
                'website' => 'https://unpad.ac.id',
                'kontak' => '(022) 84288888',
                'alamat' => 'Jl. Raya Bandung Sumedang KM.21, Jatinangor, Sumedang, Jawa Barat 45363',
            ],
        ];

        $kampusModels = [];
        foreach ($kampusData as $k) {
            $kampusModels[] = KampusMitra::create(array_merge($k, ['is_active' => true]));
        }

        // 5. Create 15 Beasiswa (aktif, draft, tutup)
        $beasiswaData = [
            // UGM
            [
                'kampus_mitra_id' => 3, // UGM
                'nama_beasiswa' => 'Beasiswa Prestasi Unggulan',
                'deskripsi' => 'Beasiswa penuh untuk program sarjana bagi putra-putri terbaik bangsa berprestasi akademik luar biasa.',
                'jenis' => 'full_funding',
                'persyaratan' => ['Nilai Rapor rata-rata > 85', 'Sertifikat Prestasi Nasional', 'Rekomendasi MGBK'],
                'kuota' => 50,
                'deadline' => Carbon::now()->addDays(12)->toDateString(), // Matches "Sisa 12 Hari" mockup
                'status' => 'aktif',
            ],
            // ITB
            [
                'kampus_mitra_id' => 2, // ITB
                'nama_beasiswa' => 'Beasiswa Riset Teknologi',
                'deskripsi' => 'Beasiswa bagi siswa berbakat di bidang sains dan teknik untuk mendukung riset tingkat sarjana di ITB.',
                'jenis' => 'partial_funding',
                'persyaratan' => ['Nilai Rapor MIPA > 88', 'Lulus seleksi portofolio', 'Esai motivasi riset'],
                'kuota' => 20,
                'deadline' => '2026-11-30', // Matches "30 Nov 2024" in modern year
                'status' => 'aktif',
            ],
            // UI
            [
                'kampus_mitra_id' => 1, // UI
                'nama_beasiswa' => 'Beasiswa Indonesia Bangkit',
                'deskripsi' => 'Beasiswa penuh untuk program sarjana bagi putra-putri berprestasi yang ingin melanjutkan studi di bidang ekonomi dan humaniora.',
                'jenis' => 'full_funding',
                'persyaratan' => ['Nilai Rapor > 85', 'IELTS 6.0', 'Esai Kontribusi'],
                'kuota' => 100,
                'deadline' => '2026-12-15', // Matches "15 Des 2024"
                'status' => 'aktif',
            ],
            // Telkom
            [
                'kampus_mitra_id' => 4, // Telkom
                'nama_beasiswa' => 'Program Beasiswa Digital Talent',
                'deskripsi' => 'Dukungan biaya pendidikan khusus bagi siswa yang memiliki minat mendalam di bidang pengembangan perangkat lunak dan AI.',
                'jenis' => 'partial_funding',
                'persyaratan' => ['Nilai Rapor > 80', 'Sertifikat programming / informatika', 'Tes logika dasar'],
                'kuota' => 150,
                'deadline' => '2027-01-20', // Matches "20 Jan 2025"
                'status' => 'aktif',
            ],
            // Unpad
            [
                'kampus_mitra_id' => 5, // Unpad
                'nama_beasiswa' => 'Beasiswa Asrama Mahasiswa',
                'deskripsi' => 'Bantuan biaya asrama dan uang saku bulanan untuk mahasiswa berprestasi dari luar daerah Jawa Barat.',
                'jenis' => 'akomodasi',
                'persyaratan' => ['Surat Keterangan KIP/SKTM', 'Nilai Rapor > 78', 'Rapor S1-S5'],
                'kuota' => 30,
                'deadline' => '2027-02-10', // Matches "10 Feb 2025"
                'status' => 'aktif',
            ],
            // UGM 2
            [
                'kampus_mitra_id' => 3, // UGM
                'nama_beasiswa' => 'Beasiswa KIP Kuliah Jalur Khusus',
                'deskripsi' => 'Beasiswa bantuan pendidikan penuh dari pemerintah terintegrasi khusus untuk siswa sekolah binaan MGBK.',
                'jenis' => 'full_funding',
                'persyaratan' => ['Memiliki KIP/SKTM', 'Lulus seleksi SNBP/SNBT', 'Rekomendasi Guru BK'],
                'kuota' => 120,
                'deadline' => Carbon::now()->addDays(30)->toDateString(),
                'status' => 'aktif',
            ],
            // ITB 2 (Tutup)
            [
                'kampus_mitra_id' => 2, // ITB
                'nama_beasiswa' => 'Beasiswa Riset STEM ITB',
                'deskripsi' => 'Program beasiswa sains, teknologi, teknik, dan matematika yang terbukti mempercepat lulusan berkarir di industri.',
                'jenis' => 'partial_funding',
                'persyaratan' => ['Saintek', 'Esai Riset', 'Nilai Rapor > 85'],
                'kuota' => 15,
                'deadline' => Carbon::now()->subDays(5)->toDateString(),
                'status' => 'tutup',
            ],
            // Telkom 2 (Tutup)
            [
                'kampus_mitra_id' => 4, // Telkom
                'nama_beasiswa' => 'Beasiswa Kemitraan Industri',
                'deskripsi' => 'Beasiswa ikatan dinas dengan industri telekomunikasi multinasional yang mencakup biaya kuliah 100% dan kerja praktek.',
                'jenis' => 'full_funding',
                'persyaratan' => ['Nilai Rapor > 85', 'Lulus psikotes', 'Bebas buta warna'],
                'kuota' => 25,
                'deadline' => Carbon::now()->subDays(10)->toDateString(),
                'status' => 'tutup',
            ],
            // UI 2 (Draft)
            [
                'kampus_mitra_id' => 1, // UI
                'nama_beasiswa' => 'Beasiswa Hafidz Quran',
                'deskripsi' => 'Beasiswa khusus bagi hafidz dan hafidzah yang memiliki hafalan minimal 10 juz untuk kuliah di program studi manapun di UI.',
                'jenis' => 'partial_funding',
                'persyaratan' => ['Sertifikat hafidz 10 juz', 'Nilai Rapor > 80', 'Rekomendasi dari pondok/sekolah'],
                'kuota' => 25,
                'deadline' => Carbon::now()->addMonths(3)->toDateString(),
                'status' => 'draft',
            ],
            // UGM 3 (Draft)
            [
                'kampus_mitra_id' => 3, // UGM
                'nama_beasiswa' => 'Beasiswa Olahraga Nasional',
                'deskripsi' => 'Program beasiswa yang dirancang khusus untuk atlet pelajar nasional agar tetap berprestasi di tingkat perguruan tinggi.',
                'jenis' => 'partial_funding',
                'persyaratan' => ['Sertifikat Juara POPNAS/Kejurnas', 'Nilai Rapor > 75'],
                'kuota' => 15,
                'deadline' => Carbon::now()->addMonths(2)->toDateString(),
                'status' => 'draft',
            ],
            // Unpad 2 (Draft)
            [
                'kampus_mitra_id' => 5, // Unpad
                'nama_beasiswa' => 'Beasiswa Seni MGBK',
                'deskripsi' => 'Apresiasi khusus bagi siswa berprestasi di bidang seni rupa, musik, tari, dan teater binaan MGBK.',
                'jenis' => 'akomodasi',
                'persyaratan' => ['Portofolio Karya', 'Nilai Rapor > 78'],
                'kuota' => 10,
                'deadline' => Carbon::now()->addMonths(4)->toDateString(),
                'status' => 'draft',
            ],
            // UI 3 (Tutup)
            [
                'kampus_mitra_id' => 1, // UI
                'nama_beasiswa' => 'Beasiswa Difabel Peduli',
                'deskripsi' => 'Komitmen UI untuk aksesibilitas pendidikan tinggi bagi seluruh kalangan, memberikan akomodasi ramah difabel dan biaya hidup.',
                'jenis' => 'full_funding',
                'persyaratan' => ['Surat keterangan disabilitas', 'Nilai Rapor > 75'],
                'kuota' => 10,
                'deadline' => Carbon::now()->subDays(20)->toDateString(),
                'status' => 'tutup',
            ],
            // ITB 3 (Aktif - Beasiswa Bakti ITB)
            [
                'kampus_mitra_id' => 2, // ITB
                'nama_beasiswa' => 'Beasiswa Bakti ITB',
                'deskripsi' => 'Bantuan studi untuk siswa dari wilayah tertinggal, terdepan, dan terluar (3T) di seluruh Indonesia.',
                'jenis' => 'full_funding',
                'persyaratan' => ['Asal wilayah 3T', 'KIP/SKTM', 'Lulus SNMPTN/SBMPTN'],
                'kuota' => 50,
                'deadline' => '2026-10-15',
                'status' => 'aktif',
            ],
            // UGM 4 (Aktif - Beasiswa Mandiri UGM)
            [
                'kampus_mitra_id' => 3, // UGM
                'nama_beasiswa' => 'Beasiswa Mandiri UGM',
                'deskripsi' => 'Program beasiswa kemitraan CSR perusahaan swasta nasional untuk pendanaan pendidikan program sarjana UGM.',
                'jenis' => 'partial_funding',
                'persyaratan' => ['Nilai Rapor > 82', 'Lulus ujian mandiri UGM'],
                'kuota' => 80,
                'deadline' => '2026-10-20',
                'status' => 'aktif',
            ],
            // Telkom 3 (Aktif - Beasiswa Vokasi Mandiri)
            [
                'kampus_mitra_id' => 4, // Telkom
                'nama_beasiswa' => 'Beasiswa Vokasi Mandiri',
                'deskripsi' => 'Program beasiswa vokasi untuk mencetak tenaga ahli siap kerja di bidang rekayasa dan teknologi.',
                'jenis' => 'partial_funding',
                'persyaratan' => ['Lulusan SMK/SMA', 'Nilai Rapor > 78'],
                'kuota' => 100,
                'deadline' => '2026-09-25',
                'status' => 'aktif',
            ],
        ];

        $beasiswaModels = [];
        foreach ($beasiswaData as $b) {
            $beasiswaModels[] = Beasiswa::create($b);
        }

        // 6. Create 20 Rekomendasi
        // Let's create realistic recommendations matching students and BK teachers
        $rekomendasiData = [
            // BK Siti Aminah (SMKN 2 Bandung) seeds SMKN 2 Bandung students (Siti Aminah, Bunga Nabilla)
            [
                'data_siswa_id' => 3, // Siti Aminah (Siswa)
                'beasiswa_id' => 3, // Beasiswa Indonesia Bangkit (UI)
                'guru_bk_id' => 2, // Siti Aminah M.Pd
                'persentase_kecocokan' => 85,
                'status' => 'terverifikasi',
                'catatan' => 'Siswa memiliki prestasi akademik yang sangat konsisten, sangat cocok untuk program beasiswa di UI.',
            ],
            [
                'data_siswa_id' => 3, // Siti Aminah (Siswa)
                'beasiswa_id' => 5, // Beasiswa Asrama Mahasiswa (Unpad)
                'guru_bk_id' => 2, // Siti Aminah M.Pd
                'persentase_kecocokan' => 90,
                'status' => 'terverifikasi',
                'catatan' => 'Rekomendasi asrama sangat krusial mengingat kondisi ekonomi keluarga siswa.',
            ],
            [
                'data_siswa_id' => 7, // Bunga Nabilla
                'beasiswa_id' => 4, // Beasiswa Digital Talent (Telkom)
                'guru_bk_id' => 2, // Siti Aminah M.Pd
                'persentase_kecocokan' => 78,
                'status' => 'menunggu',
                'catatan' => 'Siswa berbakat di bidang industri kreatif dan manajemen.',
            ],

            // BK Budi Santoso (SMA Negeri 1 Jakarta) seeds SMA 1 students (Ahmad Fauzi, Aditya Pratama, Ahmad Subarkah, Rian Hidayat)
            [
                'data_siswa_id' => 1, // Ahmad Fauzi
                'beasiswa_id' => 1, // Beasiswa Prestasi Unggulan (UGM)
                'guru_bk_id' => 3, // Budi Santoso S.Pd
                'persentase_kecocokan' => 85, // Matches the "85% Cocok" Siswa Dashboard mockup!
                'status' => 'terverifikasi',
                'catatan' => 'Ahmad adalah murid teladan dengan kepribadian luar biasa.',
            ],
            [
                'data_siswa_id' => 1, // Ahmad Fauzi
                'beasiswa_id' => 2, // Beasiswa Riset Teknologi (ITB)
                'guru_bk_id' => 3, // Budi Santoso S.Pd
                'persentase_kecocokan' => 92, // Matches the "92% Cocok" Siswa Dashboard mockup!
                'status' => 'terverifikasi',
                'catatan' => 'Kemampuan riset fisika yang kuat, sangat sesuai untuk ITB.',
            ],
            [
                'data_siswa_id' => 2, // Aditya Pratama
                'beasiswa_id' => 3, // Beasiswa Indonesia Bangkit (UI)
                'guru_bk_id' => 3, // Budi Santoso S.Pd
                'persentase_kecocokan' => 88,
                'status' => 'terverifikasi',
                'catatan' => 'Memiliki kecakapan luar biasa di bidang sosial dan hukum.',
            ],
            [
                'data_siswa_id' => 6, // Ahmad Subarkah
                'beasiswa_id' => 6, // KIP Kuliah (UGM)
                'guru_bk_id' => 3, // Budi Santoso S.Pd
                'persentase_kecocokan' => 80,
                'status' => 'terverifikasi',
                'catatan' => 'Kondisi ekonomi kurang mampu, direkomendasikan mendapat bantuan KIP.',
            ],
            [
                'data_siswa_id' => 6, // Ahmad Subarkah
                'beasiswa_id' => 5, // Asrama (Unpad)
                'guru_bk_id' => 3, // Budi Santoso S.Pd
                'persentase_kecocokan' => 74,
                'status' => 'menunggu',
                'catatan' => 'Menunggu verifikasi asrama.',
            ],
            [
                'data_siswa_id' => 10, // Rian Hidayat
                'beasiswa_id' => 1, // Beasiswa Prestasi Unggulan (UGM)
                'guru_bk_id' => 3, // Budi Santoso S.Pd
                'persentase_kecocokan' => 83,
                'status' => 'dikirim',
                'catatan' => 'Berkas pendaftaran telah dikirim ke panitia UGM.',
            ],

            // BK Dewi Lestari (SMA BPK Penabur) seeds SMA Penabur students (Rizky Ramadhan, Dandi Pratama)
            [
                'data_siswa_id' => 4, // Rizky Ramadhan
                'beasiswa_id' => 2, // Beasiswa Riset Teknologi (ITB)
                'guru_bk_id' => 4, // Dewi Lestari S.Psi
                'persentase_kecocokan' => 95,
                'status' => 'terverifikasi',
                'catatan' => 'Kecerdasan luar biasa, peraih medali olimpiade fisika.',
            ],
            [
                'data_siswa_id' => 8, // Dandi Pratama
                'beasiswa_id' => 4, // Digital Talent (Telkom)
                'guru_bk_id' => 4, // Dewi Lestari S.Psi
                'persentase_kecocokan' => 80,
                'status' => 'revisi',
                'catatan' => 'Harap mengunggah sertifikat kepramukaan/Paskibra yang terbaru.',
            ],

            // Other students (Larasati Putri, Eka Saputra) - BK Budi Santoso helps
            [
                'data_siswa_id' => 5, // Larasati Putri
                'beasiswa_id' => 3, // UI
                'guru_bk_id' => 3, // Budi Santoso
                'persentase_kecocokan' => 82,
                'status' => 'terverifikasi',
                'catatan' => 'Siswa memiliki kemauan belajar yang tinggi.',
            ],
            [
                'data_siswa_id' => 9, // Eka Saputra
                'beasiswa_id' => 5, // Unpad
                'guru_bk_id' => 3, // Budi Santoso
                'persentase_kecocokan' => 87,
                'status' => 'terverifikasi',
                'catatan' => 'Bakat seni rupa yang luar biasa, direkomendasikan di Unpad.',
            ],
            [
                'data_siswa_id' => 9, // Eka Saputra
                'beasiswa_id' => 4, // Telkom
                'guru_bk_id' => 3, // Budi Santoso
                'persentase_kecocokan' => 76,
                'status' => 'dibatal', // We can mock dibatal or revisi
                'status' => 'revisi',
                'catatan' => 'Esai tentang minat karir di bidang desain grafis perlu diperbaiki.',
            ],
        ];

        // Seed other items to complete 20 recommendations
        for ($i = 0; $i < 6; $i++) {
            $studentIndex = $i % 10;
            $beasiswaIndex = ($i + 5) % 15;
            $bkIndex = ($i % 3) + 1; // bk1, bk2, bk3 -> user id 2, 3, 4
            
            $rekomendasiData[] = [
                'data_siswa_id' => $studentIndex + 1,
                'beasiswa_id' => $beasiswaIndex + 1,
                'guru_bk_id' => $bkIndex + 1,
                'persentase_kecocokan' => rand(70, 95),
                'status' => ['menunggu', 'terverifikasi', 'revisi', 'dikirim'][rand(0, 3)],
                'catatan' => 'Rekomendasi otomatis sistem berdasarkan data akademik.',
            ];
        }

        foreach ($rekomendasiData as $r) {
            Rekomendasi::create($r);
        }
    }
}
