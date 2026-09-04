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
                                <form action="{{ route('products-recycle.restore', $product->id) }}"  method="POST">
                                    @csrf
                                    
                                    <x-dashboard.card-btn
                                        class="ver-mais-producto
                                        bg-blue-600"
                                        onclick="return confirm('Recuperar producto')"
                                    >

                                        Restaurar
                                    </x-dashboard.card-btn>
                                </form>
                                
                                <form method="POST" action="{{ route('products-recycle.forceDelete', $product->id) }}">
                                    @csrf

                                    <x-dashboard.card-btn title="Excluir definitvamente" 
                                    class="ver-mais-producto 
                                    bg-red-600"
                                        onclick="return confirm('Tem a certeza que pretende eliminar definitivamente?')"
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

    <x-dashboard.float-btn 
        class="bg-blue-600 bottom-8" 
        onclick="abrirModal()"
    >
        <i class="fa-solid fa-plus"></i>
    </x-dashboard.float-btn> 

    <x-dashboard.modal >
        <x-dashboard.actions-container>
            <x-dashboard.action-card>
                icone

                <x-slot:type>
                    <form action="{{ route('products-recycle.restoreAll') }}" method="post">
                        @csrf

                        <button type="submit" class="text-blue-600 cursor-pointer" onclick="return confirm('Recuperar productos')">
                            Restaurar Productos
                        </button>
                    </form>
                </x-slot:type>
            </x-dashboard.action-card>
            
            <x-dashboard.action-card>
                icone

                <x-slot:type>
                    <form action="{{ route('products-recycle.cleanAll') }}" method="post">
                        @csrf

                        <button type="submit" class="text-red-600 cursor-pointer" onclick="return confirm('Tem a certeza que deseja esvaziar a reciclagem?')">
                            Apagar Productos
                        </button>
                    </form>
                </x-slot:type>
            </x-dashboard.action-card>
        </x-dashboard.actions-container>
    </x-dashboard.modal>
@endsection 