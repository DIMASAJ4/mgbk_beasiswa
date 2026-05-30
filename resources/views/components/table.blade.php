@props([
    'title' => null,
    'subtitle' => null,
    'action' => null
])

<div class="bg-white rounded-2xl border border-slate-100 p-6">
    @if ($title || $subtitle || $action)
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                @if ($title)
                    <h3 class="heading-font text-lg font-bold text-slate-800">{{ $title }}</h3>
                @endif
                @if ($subtitle)
                    <p class="text-slate-400 text-xs mt-0.5">{{ $subtitle }}</p>
                @endif
            </div>
            @if ($action)
                <div class="flex items-center gap-3">
                    {{ $action }}
                </div>
            @endif
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            @if (isset($thead))
                <thead>
                    <tr class="border-b border-slate-100 text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">
                        {{ $thead }}
                    </tr>
                </thead>
            @endif
            <tbody class="divide-y divide-slate-50 text-xs">
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
