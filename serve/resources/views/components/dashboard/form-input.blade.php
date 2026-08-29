@props(['canotEdit' => null])

<input {{ $attributes }} 
class="outline-2 p-2 outline-zinc-400 dark:bg-[var(--dark-fundo-card)] rounded-xs focus:outline-zinc-900" @disabled($canotEdit)>