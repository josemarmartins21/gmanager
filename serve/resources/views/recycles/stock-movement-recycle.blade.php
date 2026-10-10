@use('Illuminate\Support\Str')

@extends('layouts.main')

@section('title', 'GManager - Reciclagem')
@section('section', 'Reciclagem')

@section('content')
    <x-dashboard.alert />
    <section id="index-container">
        <x-dashboard.content>
            <x-dashboard.title-section>
                Movimentações de Estoque
            </x-dashboard.title-section>

            <x-dashboard.cards-container>
                    @forelse ($stockMovements as $stockMovement) 
                        <x-dashboard.card 
                            :data="$stockMovement"
                        >
                            <x-slot:header>
                                <h3 class="text-2xl font-semibold">{{ $stockMovement->total_units }}</h3>
                            </x-slot:header>
    
                            <x-slot:body>
                                <ul>
                                    <li class="text-3xl mb-1  text-zinc-100">{{ $stockMovement->created_at->format('d/m/Y') }}</li>
                                </ul>
                            </x-slot:body>
    
                            <x-slot:footer>
                                <form action="{{ route('stock-movement-recycle.restore', $stockMovement->id) }}"  method="POST">
                                    @csrf
                                    
                                    <x-dashboard.card-btn
                                        class="ver-mais-venda
                                        bg-blue-600"
                                        onclick="return confirm('Recuperar movimentação de estoque')"
                                    >

                                        <i class="fa-solid fa-arrows-rotate"></i> Restaurar
                                    </x-dashboard.card-btn>
                                </form>
                                
                                <form method="POST" action="{{ route('stock-movement-recycle.forceDelete', $stockMovement->id) }}">
                                    @csrf

                                    <x-dashboard.card-btn title="Excluir definitvamente" 
                                    class="ver-mais-venda 
                                    bg-red-600"
                                        onclick="return confirm('Tem a certeza que pretende eliminar definitivamente?')"
                                    title="Excluir definitivamente"    
                                    >
                                     @method('Delete')

                                     <i class="fa-solid fa-delete-left"></i> Excluir def...
                                    </x-dashboard.card-btn>
                                </form>
                            </x-slot:footer>
                        </x-dashboard.card>
                    @empty 
                    
                    @endforelse
            </x-dashboard.cards-container>
            {{ $stockMovements->links() }}
       </x-dashboard.content>
    </section>

    <x-dashboard.float-btn 
        class="bg-blue-600 bottom-8" 
        onclick="abrirModal()"
    >
        <i class="fa-solid fa-ellipsis text-2xl"></i>
    </x-dashboard.float-btn> 

    <x-dashboard.modal >
        <x-dashboard.actions-container>
            <x-dashboard.action-card>
                <x-slot:type>
                    <form action="{{ route('stock-movement-recycle.restoreAll') }}" method="post">
                        @csrf

                        <button 
                            type="submit" class="text-blue-600 cursor-pointer" 
                            onclick="return confirm('Recuperar as Movimentações de Estoque')"
                            title="Restaurar Movimentações de Estoque"
                        >
                            <i class="fa-solid fa-arrows-rotate text-3xl"></i>
                        </button>
                    </form>
                </x-slot:type>
            </x-dashboard.action-card>
            
            <x-dashboard.action-card>
                <x-slot:type>
                    <form action="{{ route('stock-movement-recycle.cleanAll') }}" method="post">
                        @csrf

                        <button 
                            type="submit" 
                            class="text-red-600 cursor-pointer" onclick="return confirm('Tem a certeza que deseja esvaziar a reciclagem?')"
                            title="Excluir Todas as Movimentações de Estoque"
                        >
                            <i class="fa-solid fa-delete-left text-3xl"></i> 
                        </button>
                    </form>
                </x-slot:type>
            </x-dashboard.action-card>
        </x-dashboard.actions-container>
    </x-dashboard.modal>
@endsection 