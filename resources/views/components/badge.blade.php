@props([
    'variant' => 'draft',
    'value' => null
])

@php
    $status = strtolower($value ?? $variant);
    
    switch ($status) {
        case 'aktif':
        case 'terverifikasi':
            $classes = 'bg-[#e8f4f0] text-[#1D9E75] border-[#1D9E75]/20';
            $label = $value ?? 'Aktif';
            break;
            
        case 'draft':
        case 'menunggu':
            $classes = 'bg-amber-50 text-amber-700 border-amber-100';
            $label = $value ?? ($status === 'draft' ? 'Draft' : 'Menunggu');
            break;
            
        case 'tutup':
        case 'revisi':
            $classes = 'bg-rose-50 text-rose-700 border-rose-100';
            $label = $value ?? ($status === 'tutup' ? 'Tutup' : 'Revisi');
            break;
            
        case 'dikirim':
            $classes = 'bg-indigo-50 text-indigo-700 border-indigo-100';
            $label = $value ?? 'Dikirim';
            break;
            
        default:
            $classes = 'bg-slate-50 text-slate-600 border-slate-200';
            $label = $value ?? ucfirst($status);
            break;
    }
@endphp

<span {{ $attributes->merge(['class' => "inline-flex px-2.5 py-0.5 rounded-full text-[10px] font-bold border uppercase tracking-wider {$classes}"]) }}>
    {{ $label }}
</span>
