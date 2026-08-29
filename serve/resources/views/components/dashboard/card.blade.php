@props(['data' => null, 'plan' => null])

@php($item = $data ?? $plan)

<div {{ $attributes->merge(['class' => 'card']) }}
     data-item='@json($item)'>  
    <div>{{ $header }}</div>
    
    <div class="body">{{ $body }}</div>
    
    <div {{ $attributes->merge(['class' => 'flex items-center flex-wrap justify-between']) }}>
        {{ $footer }}
    </div>
</div>