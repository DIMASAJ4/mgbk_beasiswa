@props([
    'icon' => 'fa-solid fa-chart-line',
    'label' => 'Statistik',
    'value' => '0',
    'trend' => null,
    'trendUp' => true
])

<div class="bg-white rounded-2xl border border-slate-100 p-6 hover:shadow-md transition-shadow duration-200 group">
    <div class="flex items-start justify-between">
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ $label }}</p>
            <h3 class="heading-font text-3xl font-extrabold text-[#1a3d6e] mt-2">{{ $value }}</h3>
        </div>
        <div class="h-12 w-12 rounded-xl bg-slate-50 border border-slate-100 text-[#1a3d6e] flex items-center justify-center text-xl group-hover:bg-[#1D9E75] group-hover:text-white group-hover:border-transparent transition-all duration-200">
            <i class="{{ $icon }}"></i>
        </div>
    </div>
    @if ($trend)
        <div class="flex items-center gap-1.5 mt-4 text-[11px] font-semibold {{ $trendUp ? 'text-[#1D9E75]' : 'text-rose-600' }}">
            <i class="fa-solid {{ $trendUp ? 'fa-circle-arrow-up' : 'fa-circle-arrow-down' }}"></i>
            <span>{{ $trend }}</span>
        </div>
    @endif
</div>
