@extends('layouts.main')

@section('title', 'GManager - Productos')
@section('section', 'Productos')

@section('content')
    <x-dashboard.alert />
    <section id="index-container">
               <x-dashboard.content>
            <x-dashboard.title-section>
                Productos
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
                                    <li class="text-zinc-400">{{ $product->current_stock }} uni. </li>
                                </ul>
                            </x-slot:body>
    
                            <x-slot:footer>
                                <x-dashboard.card-btn 
                                    class="ver-mais-producto 
                                    bg-blue-600"
                                >
                                    Ver Mais
                                </x-dashboard.card-btn>
    
                                <x-dashboard.action-btn-container>
                                    <x-dashboard.action-btn 
                                        type="link" 
                                        class="bg-green-700"
                                        href="{{ route('products.edit', ['product' => $product->id]) }}"
                                    >
                                        <i class="fa-solid fa-edit text-xl"></i>
                                    </x-dashboard.action-btn>
    
                                    <form action="{{ route('products.destroy', ['product' => $product->id]) }}" 
                                        method="POST" >

                                        @csrf
                                        @method('Delete')

                                        <x-dashboard.action-btn onclick="return confirm('Tem a certeza que pretende eliminar?')" class="bg-red-700">
                                            <i class="fa-solid fa-trash text-xl"></i>
                                        </x-dashboard.action-btn>
                                    </form>
                                </x-dashboard.action-btn-container>
                            </x-slot:footer>
                        </x-dashboard.card>
                    @empty 
                    
                    @endforelse
            </x-dashboard.cards-container>
            {{ $products->links() }}
       </x-dashboard.content>
    </section>

    <x-dashboard.float-btn 
        bottom="2"
        :rota="route('products.create')"
        type="a"
        class="bg-blue-600 bottom-8" 
    >
        <i class="fa-solid fa-plus"></i>
    </x-dashboard.float-btn> 
@endsection 