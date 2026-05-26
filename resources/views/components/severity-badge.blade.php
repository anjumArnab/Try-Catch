@props(['level' => 'error'])

@php
    $styles = [
        'debug' => 'bg-gray-100 text-gray-700',
        'info' => 'bg-blue-100 text-blue-700',
        'warning' => 'bg-yellow-100 text-yellow-800',
        'error' => 'bg-red-100 text-red-700',
        'fatal' => 'bg-red-600 text-white',
    ];
    $class = $styles[$level] ?? $styles['error'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {$class}"]) }}>
    {{ ucfirst($level) }}
</span>
