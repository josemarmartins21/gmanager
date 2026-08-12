<a {{ $attributes->merge(['class' => 'fixed w-16 h-16 rounded-full font-bold text-white transition duration-500 bottom-16 transform shadow-lg active:scale-90 z-[20px] text-3xl p-5 md:cursor-pointer dark:bg-green-950 right-8']) }}>
    {{ $slot }}
</a>