@use('Illuminate\Support\Str')

@extends('layouts.main')

@section('title', 'GManager - Productos')
@section('section', 'Productos')

@section('content')
    <x-dashboard.alert />
    <section id="index-container">
        <x-dashboard.content>
            <x-dashboard.title-section>
                Reciclagem de Productos
            </x-dashboard.title-section>

            <x-dashboard.cards-container>
                    @forelse ($products as $product) 
                        <x-dashboard.card 
                            :data="$product"
                        >
                            <x-slot:header>
                                <h3 class="text-2xl font-semibold">{{ $product->name }}</h3>
                            </x-slot:header>
    
                            <x-slot:body>
                                <ul>
                                    <li class="text-3xl mb-1  text-zinc-100">{{ number_format($product->price, 2, ',', '.') }}Kz</li>
                                </ul>
                            </x-slot:body>
    
                            <x-slot:footer>
                                <form action="{{ route('products-recycle.restore', $product->id) }}" method="POST">
                                    <x-dashboard.card-btn
                                        class="ver-mais-producto
                                        bg-blue-600"
                                    >
                                        Restaurar
                                    </x-dashboard.card-btn>
                                </form>
                                
                                <form method="POST" action="{{ route('products-recycle.forceDelete', $product->id) }}">
                                    <x-dashboard.card-btn title="Excluir definitvamente" 
                                    class="ver-mais-producto 
                                    bg-red-600"
                                    onclick="return confirm('Tem a certeza que pretende eliminar?')"
                                    >
                                     @method('Delete')
                                     Excluir def...
                                    </x-dashboard.card-btn>
                                </form>
                            </x-slot:footer>
                        </x-dashboard.card>
                    @empty 
                    
                    @endforelse
            </x-dashboard.cards-container>
            {{ $products->links() }}
       </x-dashboard.content>
    </section>

    <form action="{{ route('products-recycle.restoreAll') }}" method="post">
        @csrf

        <x-dashboard.float-btn class="bg-blue-600" onclick="return confirm('Recuperar productos')">
            +
        </x-dashboard.float-btn>
    </form>
    
    <form action="{{ route('products-recycle.cleanAll') }}" method="post">
        @csrf

        <x-dashboard.float-btn :bottom="5" class="bg-red-600" onclick="return confirm('Tem a certeza que deseja esvaziar a reciclagem?')">
            +
        </x-dashboard.float-btn>
    </form>
@endsection 