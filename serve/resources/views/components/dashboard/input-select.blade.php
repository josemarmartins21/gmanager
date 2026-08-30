<select {{ $attributes->merge(['class' => 'outline-2 p-2 dark:bg-black outline-zinc-400 rounded-xs focus:outline-zinc-900']) }}  >
    {{ $slot }}
</select>