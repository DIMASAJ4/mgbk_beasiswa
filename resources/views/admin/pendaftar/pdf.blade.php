<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Daftar Peminat Beasiswa — {{ $beasiswa->nama_beasiswa }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #1a3d6e;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #1a3d6e;
            font-size: 16px;
            margin: 0;
            text-transform: uppercase;
        }
        .header p {
            margin: 3px 0 0;
            color: #555;
            font-weight: bold;
        }
        .meta-info {
            margin-bottom: 20px;
            font-size: 10px;
            color: #555;
            display: flex;
            justify-content: space-between;
            background-color: #f8fafc;
            padding: 10px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
        }
        .meta-info table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }
        .meta-info td {
            padding: 2px 5px;
            border: none;
            background: none !important;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            padding: 8px 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #1a3d6e;
            color: #fff;
            text-transform: uppercase;
            font-size: 9px;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-admin { background-color: #e0f2fe; color: #0369a1; }
        .badge-guru { background-color: #dcfce7; color: #15803d; }
        
        .footer {
            margin-top: 50px;
            text-align: right;
            font-size: 10px;
        }
        .signature-space {
            margin-top: 60px;
            font-weight: bold;
        }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <!-- Header Banner -->
    <div class="header">
        <h1>Daftar Siswa Peminat Beasiswa</h1>
        <p>Musyawarah Guru Bimbingan Konseling (MGBK) Kota Padangsidimpuan</p>
    </div>

    <!-- Scholarship Metadata Card -->
    <div class="meta-info">
        <table style="width: 100%;">
            <tr>
                <td style="width: 15%; font-weight: bold;">Beasiswa:</td>
                <td style="width: 45%;">{{ $beasiswa->nama_beasiswa }}</td>
                <td style="width: 15%; font-weight: bold;">Kuota:</td>
                <td style="width: 25%;">{{ $beasiswa->kuota }} orang</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Kampus Mitra:</td>
                <td>{{ $beasiswa->kampusMitra->nama_kampus ?? 'N/A' }}</td>
                <td style="font-weight: bold;">Pendaftar Terisi:</td>
                <td>{{ count($pendaftars) }} siswa</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Jenis Pembiayaan:</td>
                <td>{{ ucwords(str_replace('_', ' ', $beasiswa->jenis)) }}</td>
                <td style="font-weight: bold;">Tanggal Cetak:</td>
                <td>{{ now()->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</td>
            </tr>
        </table>
    </div>

    <!-- Applicants Data Table -->
    <table>
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 20%;">Nama Siswa</th>
                <th style="width: 15%;">NISN</th>
                <th style="width: 25%;">Sekolah & Kelas</th>
                <th style="width: 10%; text-align: center;">Nilai Rata</th>
                <th style="width: 13%;">Ekonomi Check</th>
                <th style="width: 12%;">Metode Rekomendasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pendaftars as $index => $p)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td><strong>{{ $p->dataSiswa->user->name ?? 'N/A' }}</strong></td>
                <td>{{ $p->dataSiswa->user->nisn ?? '-' }}</td>
                <td>
                    {{ $p->dataSiswa->user->sekolah ?? 'SMA Negeri' }}<br>
                    <span style="font-size: 9px; color: #666;">Kelas: {{ $p->dataSiswa->user->kelas ?? '-' }}</span>
                </td>
                <td style="text-align: center; font-weight: bold; color: #1D9E75;">{{ number_format($p->dataSiswa->nilai_rata, 2) }}</td>
                <td>{{ ucwords(str_replace('_', ' ', $p->dataSiswa->kondisi_ekonomi)) }}</td>
                <td>
                    @if($p->direkomendasikan_oleh === 'admin')
                        <span class="badge badge-admin">Admin</span>
                    @else
                        <span class="badge badge-guru">Guru BK</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 20px; color: #888;">
                    Belum ada siswa yang mendaftar atau memilih beasiswa ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Signature Footer -->
    <div class="footer">
        <p>Padangsidimpuan, {{ now()->format('d M Y') }}</p>
        <p>Hormat Kami,</p>
        <div class="signature-space">
            <p>Admin MGBK Padangsidimpuan</p>
        </div>
    </div>

</body>
</html>
