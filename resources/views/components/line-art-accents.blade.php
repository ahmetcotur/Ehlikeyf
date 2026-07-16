@props([
    'tone' => 'dark',
])

@php
    $isDark = $tone === 'light';
    $color = $isDark ? 'var(--color-brand-light)' : 'var(--color-brand-olive)';
    $oliveOpacity = $isDark ? '0.035' : '0.055';
    $softOpacity = $isDark ? '0.025' : '0.04';
@endphp

<div {{ $attributes->merge(['class' => 'pointer-events-none absolute inset-0 z-0 overflow-hidden']) }} style="color: {{ $color }};" aria-hidden="true">
    {{-- Olive branch --}}
    <svg style="position:absolute;left:-3rem;top:4rem;width:12rem;height:12rem;opacity:{{ $oliveOpacity }};" viewBox="0 0 220 220" fill="none">
        <path d="M108 190 C 98 145 86 100 38 34" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        <path d="M94 128 C 72 118 53 121 36 139 C 61 147 80 143 94 128Z" stroke="currentColor" stroke-width="2"/>
        <path d="M82 96 C 61 84 43 84 25 99 C 48 110 68 109 82 96Z" stroke="currentColor" stroke-width="2"/>
        <path d="M70 66 C 52 52 35 49 17 61 C 37 76 55 78 70 66Z" stroke="currentColor" stroke-width="2"/>
        <path d="M118 152 C 139 137 158 134 179 146 C 158 164 137 166 118 152Z" stroke="currentColor" stroke-width="2"/>
        <path d="M108 116 C 128 100 147 95 169 105 C 150 124 129 130 108 116Z" stroke="currentColor" stroke-width="2"/>
        <path d="M96 82 C 113 65 131 58 153 65 C 137 84 118 92 96 82Z" stroke="currentColor" stroke-width="2"/>
    </svg>

    {{-- Sea shell --}}
    <svg style="position:absolute;right:-2.5rem;top:5.5rem;width:11rem;height:11rem;opacity:{{ $softOpacity }};" viewBox="0 0 180 180" fill="none">
        <path d="M32 126 C 44 70 70 42 90 42 C 110 42 136 70 148 126 C 118 140 62 140 32 126Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
        <path d="M90 42 V136" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
        <path d="M68 49 C 70 82 74 108 80 135" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
        <path d="M112 49 C 110 82 106 108 100 135" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
        <path d="M49 76 C 57 96 64 115 69 133" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
        <path d="M131 76 C 123 96 116 115 111 133" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
        <path d="M52 126 C 72 119 108 119 128 126" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
    </svg>

    {{-- Fish --}}
    <svg style="position:absolute;left:7%;bottom:3rem;width:10rem;height:6rem;opacity:{{ $softOpacity }};transform:rotate(-8deg);" viewBox="0 0 240 140" fill="none">
        <path d="M28 70 C 66 28 133 28 185 70 C 133 112 66 112 28 70Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
        <path d="M185 70 L222 42 L214 70 L222 98 L185 70Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
        <path d="M86 48 C 98 62 98 78 86 92" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
        <circle cx="57" cy="64" r="3" fill="currentColor"/>
        <path d="M119 39 C 112 55 112 86 119 102" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
    </svg>

    {{-- Small drifting wave / coastal line --}}
    <svg style="position:absolute;right:9%;bottom:5rem;width:14rem;height:5rem;opacity:{{ $softOpacity }};" viewBox="0 0 280 90" fill="none">
        <path d="M6 52 C 32 26 58 26 84 52 C 110 78 136 78 162 52 C 188 26 214 26 240 52 C 254 66 266 72 276 72" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        <path d="M32 68 C 54 54 76 54 98 68 C 120 82 142 82 164 68" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
    </svg>
</div>
