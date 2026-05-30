<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Rekomendasi Beasiswa MGBK</title>
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
            font-size: 18px;
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
            color: #666;
            display: flex;
            justify-content: space-between;
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
        .badge-dikirim { background-color: #e0f2fe; color: #0369a1; }
        .badge-terverifikasi { background-color: #dcfce7; color: #15803d; }
        .badge-revisi { background-color: #fee2e2; color: #b91c1c; }
        .badge-menunggu { background-color: #fef3c7; color: #b45309; }
        
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

    <!-- Printable Header Banner -->
    <div class="header">
        <h1>Laporan Rekomendasi Beasiswa MGBK</h1>
        <p>Musyawarah Guru Bimbingan Konseling (MGBK) Indonesia</p>
    </div>

    <!-- Meta Info -->
    <div class="meta-info">
        <div>
            <strong>Periode Laporan:</strong> {{ \Carbon\Carbon::parse($startDateVal)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDateVal)->format('d M Y') }}
        </div>
        <div>
            <strong>Tanggal Unduh:</strong> {{ now()->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB
        </div>
    </div>

    <!-- Data Table -->
    <table>
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 20%;">Nama Siswa</th>
                <th style="width: 15%;">Sekolah</th>
                <th style="width: 25%;">Beasiswa</th>
                <th style="width: 15%;">Kampus</th>
                <th style="width: 10%; text-align: center;">Kecocokan</th>
                <th style="width: 10%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($recommendations as $index => $rek)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $rek->dataSiswa->user->name ?? 'N/A' }}</strong><br>
                    NISN: {{ $rek->dataSiswa->user->nisn ?? '-' }}
                </td>
                <td>{{ $rek->dataSiswa->user->sekolah ?? '-' }}</td>
                <td>{{ $rek->beasiswa->nama_beasiswa ?? 'N/A' }}</td>
                <td>{{ $rek->beasiswa->kampusMitra->nama_kampus ?? 'N/A' }}</td>
                <td style="text-align: center; font-weight: bold;">{{ $rek->persentase_kecocokan }}%</td>
                <td>
                    <span class="badge badge-{{ strtolower($rek->status) }}">
                        {{ $rek->status }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 20px; color: #888;">
                    Tidak ada data rekomendasi untuk dicetak dalam periode ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Printable Signature Footer -->
    <div class="footer">
        <p>Padangsidimpuan, {{ now()->format('d M Y') }}</p>
        <p>Hormat Kami,</p>
        <div class="signature-space">
            <p>Ketua MGBK Indonesia</p>
        </div>
    </div>

</body>
</html>
