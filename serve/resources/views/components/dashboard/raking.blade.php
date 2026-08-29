@props([
    'items' => [],
    'description' => null,
    'title' => null,
])

<div class="overflow-x-auto">
    <div id="raking-container">
        <div id="header-raking">
            <p> {{ $description }} </p>
    
            <h2 class="text-3xl font-semibold">{{ $title }}</h2>   
        </div>
    
        <div id="list-raking">
            @forelse ($items as $item)
                @php($porcentage = abs(100))
                <div class="item-raking">
                    <p>
                        <strong class="text-xl">1</strong>
        
                        <span>{{ floor($porcentage) }}%</span>
                    </p>
        
                    <div class="rate-bar-container" style="width: 100%">
                        <div class="rate-bar" style="width: {{ '200' }}%"></div>
                    </div>
                </div>
                
            @empty
                <h2 class="text-3xl">Não existem assinaturas ainda</h2>
            @endforelse
        </div>
    </div>
</div>