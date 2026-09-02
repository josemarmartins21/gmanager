<button type="submit" {{ $attributes->merge(['class' => 'text-white font-bold py-2 px-4 rounded-[5px] cursor-pointer transition transform active:scale-[0.95] duration-300']) }}>
    {{ $slot }}
</button>