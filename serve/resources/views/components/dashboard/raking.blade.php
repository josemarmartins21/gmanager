@props([
    'items' => [],
    'description' => null,
    'title' => null,
])

<div class="overflow-x-auto">
    <div id="raking-container">
        <div class="border-zinc-300 mb-1 p-1">
            <p> {{ $description }} </p>
    
            <h2 class="text-2xl font-semibold">{{ $title }}</h2>   
        </div>
    
        <div class="dark:bg-[var(--dark-fundo-card)] sm:rounded-[15px]">
            @forelse ($items as $index => $item)
            
                <div class="item-raking">
            
                    <p>
                        <strong class="text-xl">
                            {{ $index + 1 }}
                        </strong>
            
                        <span>
                            {{ $item['percentage'] }}%
                        </span>
                    </p>
            
                    <div class="mb-2 flex justify-between">
                        <span>{{ $item['name'] }}</span>
            
                        <span>
                            {{ $item['total_sold'] }} un.
                        </span>
                    </div>
            
                    <div class="rate-bar-container">
            
                        <div
                            class="rate-bar"
                            style="width: {{ $item['bar_width'] }}%"
                        >
                        </div>
            
                    </div>
            
                </div>
            
            @empty
            
                <h2 class="text-3xl">
                    Não existem vendas ainda
                </h2>
            
            @endforelse
</div>
    </div>
</div>