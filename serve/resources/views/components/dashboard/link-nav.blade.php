@props(['active' => false])

<a 
    {{ $attributes }} 
    @class([
            'link-active' => $active, 
            'link-nav', 
            'dark:text-zinc-300' => !$active,
        ])
    >
    {{ $slot }}
</a>