@props([
    'bottom' => 8,
    'rota' => '',
    'type' => 'buttom',
])

@if ($type !== 'buttom')
    <a href="{{ $rota }}" id="float-btn" {{ $attributes->merge(['class' => 'active:scale-[0.95] duration-300 transition-opacity font-semibold bottom-' . $bottom]) }}>
        {{ $slot }}
    </a>
@else
    <button id="float-btn" {{ $attributes->merge(['class' => 'active:scale-[0.95] duration-300 transition-opacity font-semibold cursor-pointer bottom-' . $bottom]) }}>
         {{ $slot }}
    </button>
@endif
