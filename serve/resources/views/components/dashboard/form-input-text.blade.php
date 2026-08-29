@props([
    'cols' => 30,
    'rows' => 10,

])

<textarea 
{{ $attributes }} 
class="outline-2 p-2 outline-zinc-400 dark:bg-[var(--dark-fundo-card)] rounded-xs focus:outline-zinc-900" cols="$cols" rows="$rows">
    {{ $slot }}
</textarea>