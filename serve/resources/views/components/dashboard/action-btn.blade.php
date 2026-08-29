@props(['type' => 'button'])


@if ($type === 'button')
    <button {{ $attributes->merge(['class' => 'text-white font-bold p-1.5 rounded-[5px] cursor-pointer transition transform active:scale-[0.95] duration-300']) }}>
        {{ $slot }}
    </button>
@else 
    <a  {{ $attributes->merge(['class' => 'text-white font-bold p-1.5 rounded-[5px] cursor-pointer transition transform active:scale-[0.95] duration-300']) }}>
        {{ $slot }}
    </a>
@endif