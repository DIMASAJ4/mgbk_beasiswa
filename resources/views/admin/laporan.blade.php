<x-app-layout>
    <div class="space-y-8">
        {{-- Header & Export buttons --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="heading-font text-3xl font-extrabold text-[#1a3d6e] tracking-tight">Laporan Rekomendasi</h1>
                <p class="text-slate-500 text-sm mt-1">Laporan analitik pengajuan rekomendasi beasiswa oleh Guru BK seluruh sekolah.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.laporan.excel', ['start_date' => $startDateVal, 'end_date' => $endDateVal]) }}" 
                   class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold transition-all flex items-center gap-1.5 shadow-md shadow-emerald-600/10 cursor-pointer">
                    <i class="fa-regular fa-file-excel"></i> Export Excel
                </a>
                <a href="{{ route('admin.laporan.pdf', ['start_date' => $startDateVal, 'end_date' => $endDateVal]) }}" target="_blank"
                   class="px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold transition-all flex items-center gap-1.5 shadow-md shadow-rose-600/10 cursor-pointer">
                    <i class="fa-regular fa-file-pdf"></i> Export PDF / Cetak
                </a>
            </div>
        </div>

        {{-- Date Filters Bar --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
            <form method="GET" action="{{ route('admin.laporan') }}" class="flex flex-wrap items-end gap-4">
                <div>
                    <label for="start_date" class="block text-[10px] font-bold text-slate-450 uppercase tracking-wider mb-2">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $startDateVal }}"
                           class="px-3 py-2 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 transition-all">
                </div>
                <div>
                    <label for="end_date" class="block text-[10px] font-bold text-slate-450 uppercase tracking-wider mb-2">Tanggal Selesai</label>
                    <input type="date" id="end_date" name="end_date" value="{{ $endDateVal }}"
                           class="px-3 py-2 bg-white border border-slate-200 focus:border-[#1D9E75] focus:ring-1 focus:ring-[#1D9E75] rounded-xl text-xs text-slate-700 transition-all">
                </div>
                <button type="submit" class="px-5 py-2 rounded-xl bg-[#1D9E75] hover:bg-[#15825f] text-white text-xs font-bold transition-all shadow-sm cursor-pointer">
                    Saring Data
                </button>
            </form>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-stat-card icon="fa-solid fa-paper-plane" label="Total Rekomendasi" value="{{ $totalRekomendasi }}" trend="Dalam Periode Ini" :trendUp="true" />
            <x-stat-card icon="fa-solid fa-circle-check" label="Siswa Terlayani" value="{{ $siswaTerlayani }}" trend="Profil Terverifikasi" :trendUp="true" />
            <x-stat-card icon="fa-solid fa-graduation-cap" label="Beasiswa Aktif" value="{{ $beasiswaAktif }}" trend="Jumlah Aktif Sistem" :trendUp="true" />
            <x-stat-card icon="fa-solid fa-university" label="Kampus Mitra" value="{{ $kampusMitra }}" trend="Mitra Aktif" :trendUp="true" />
        </div>

        {{-- Charts Section (2 Columns) --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Bar Chart Card -->
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h3 class="heading-font text-base font-extrabold text-[#1a3d6e] mb-4">Tren Rekomendasi (12 Bulan Terakhir)</h3>
                <div class="h-64">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

            <!-- Donut Chart Card -->
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h3 class="heading-font text-base font-extrabold text-[#1a3d6e] mb-4">Distribusi Beasiswa per Kampus Mitra</h3>
                <div class="h-64 flex justify-center">
                    <canvas id="donutChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Detailed Table Section --}}
        <x-table title="Detail Riwayat Rekomendasi" subtitle="Daftar lengkap rekomendasi beasiswa yang diterbitkan Guru BK selama masa saringan.">
            <x-slot name="thead">
                <th class="pb-3 pr-4">Siswa</th>
                <th class="pb-3 px-4">Nama Beasiswa</th>
                <th class="pb-3 px-4">Kampus</th>
                <th class="pb-3 px-4">Guru BK</th>
                <th class="pb-3 px-4">Kecocokan</th>
                <th class="pb-3 px-4">Status</th>
                <th class="pb-3 pl-4 text-right">Tanggal</th>
            </x-slot>

            @forelse ($recommendations as $rek)
            <tr class="hover:bg-slate-50/50 transition-colors">
                <td class="py-4 pr-4">
                    <div class="font-extrabold text-[#1a3d6e]">{{ $rek->dataSiswa->user->name ?? 'N/A' }}</div>
                    <div class="text-[9px] text-slate-400 font-bold mt-0.5">NISN: {{ $rek->dataSiswa->user->nisn ?? '-' }}</div>
                </td>
                <td class="py-4 px-4 font-bold text-slate-700">
                    {{ $rek->beasiswa->nama_beasiswa ?? 'N/A' }}
                </td>
                <td class="py-4 px-4 text-slate-500 font-bold">
                    {{ $rek->beasiswa->kampusMitra->nama_kampus ?? 'N/A' }}
                </td>
                <td class="py-4 px-4 text-slate-500 font-semibold">
                    {{ $rek->guruBk->name ?? 'N/A' }}
                </td>
                <td class="py-4 px-4">
                    <div class="flex items-center gap-2">
                        <div class="w-12 bg-slate-100 h-1.5 rounded-full overflow-hidden shrink-0">
                            <div class="h-full bg-[#1D9E75] rounded-full" style="width: {{ $rek->persentase_kecocokan }}%"></div>
                        </div>
                        <span class="font-extrabold text-slate-700">{{ $rek->persentase_kecocokan }}%</span>
                    </div>
                </td>
                <td class="py-4 px-4">
                    <x-badge :variant="$rek->status" />
                </td>
                <td class="py-4 pl-4 text-right font-bold text-slate-450">
                    {{ $rek->created_at->format('d M Y') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="py-12 text-center text-slate-455 font-medium">
                    <div class="h-12 w-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-300 text-xl mx-auto mb-3">
                        <i class="fa-regular fa-folder-open"></i>
                    </div>
                    Belum ada data rekomendasi dalam jangka tanggal ini.
                </td>
            </tr>
            @endforelse
        </x-table>

        {{-- Pagination --}}
        <div class="pt-4">
            {{ $recommendations->links() }}
        </div>
    </div>

    @push('scripts')
    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data passed from controller
        const months = @json($months);
        const recommendationCounts = @json($recommendationCounts);
        
        const campusLabels = @json($campusLabels);
        const campusCounts = @json($campusCounts);

        // 1. Bar Chart Setup
        const ctxBar = document.getElementById('barChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Jumlah Rekomendasi',
                    data: recommendationCounts,
                    backgroundColor: '#1D9E75',
                    borderRadius: 6,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: { font: { size: 9, weight: 'bold' }, color: '#94a3b8' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 9, weight: 'bold' }, color: '#94a3b8' }
                    }
                }
            }
        });

        // 2. Donut Chart Setup
        const ctxDonut = document.getElementById('donutChart').getContext('2d');
        new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                labels: campusLabels,
                datasets: [{
                    data: campusCounts,
                    backgroundColor: [
                        '#1a3d6e',
                        '#1D9E75',
                        '#e8f4f0',
                        '#f59e0b',
                        '#ef4444',
                        '#a855f7'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            font: { size: 9, weight: 'bold' },
                            color: '#475569',
                            boxWidth: 10
                        }
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
