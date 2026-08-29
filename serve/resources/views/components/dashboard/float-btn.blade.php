@props([
    'bottom' => 8,
    'rota' => '',
    'type' => 'buttom',
])

@if ($type !== 'buttom')
    <a href="{{ $rota }}" id="float-btn" {{ $attributes->merge(['class' => 'bottom-' . $bottom]) }}>
        {{ $slot }}
    </a>
@else
    <button id="float-btn" {{ $attributes->merge(['class' => 'cursor-pointer bottom-' . $bottom]) }}>
         {{ $slot }}
    </button>
@endif
