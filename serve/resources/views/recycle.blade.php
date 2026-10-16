@use('Illuminate\Support\Str')

@extends('layouts.main')

@section('title', 'GManager - Reciclagem')
@section('section', 'Reciclagem')

@section('content')
    <x-dashboard.alert />
    <section id="index-container">
        <x-dashboard.content>
            <x-dashboard.title-section>
                Reciclagem
            </x-dashboard.title-section>

            <x-dashboard.cards-container>
                    <x-dashboard.card>
                            <x-slot:header>
                                <h3 class="text-2xl font-semibold">Productos</h3>
                            </x-slot:header>
    
                            <x-slot:body>
                                <p class="text-zinc-400">
                                    Exitem {{ $product_trashed_qty->count() }} productos excluidos
                                </p>
                            </x-slot:body>
    
                            <x-slot:footer>
                                <x-dashboard.card-link-btn
                                    href="{{ route('products-recycle.index') }}"
                                >
                                    Ver
                                </x-dashboard.card-link-btn>
                            </x-slot:footer>
                        </x-dashboard.card>
                    
                    <x-dashboard.card>
                            <x-slot:header>
                                <h3 class="text-2xl font-semibold">Vendas</h3>
                            </x-slot:header>
    
                            <x-slot:body>
                                <p class="text-zinc-400">
                                    Exitem {{ $sale_trashed_qty->count() }} vendas excluidas
                                </p>
                            </x-slot:body>
    
                            <x-slot:footer>
                                <x-dashboard.card-link-btn
                                    href="{{ route('sales-recycle.index') }}"
                                >
                                    Ver
                                </x-dashboard.card-link-btn>
                            </x-slot:footer>
                        </x-dashboard.card>
                    
                        <x-dashboard.card>
                            <x-slot:header>
                                <h3 class="text-2xl font-semibold">Movimentos de Estoque</h3>
                            </x-slot:header>
    
                            <x-slot:body>
                                <p class="text-zinc-400">
                                    Exitem {{ $stock_movement_trashed_qty->count() }} movimentos de estoque excluidos
                                </p>
                            </x-slot:body>
    
                            <x-slot:footer>
                                <x-dashboard.card-link-btn
                                    href="{{ route('stock-movement-recycle.index') }}"
                                >
                                    Ver
                                </x-dashboard.card-link-btn>
                            </x-slot:footer>
                        </x-dashboard.card>
            </x-dashboard.cards-container>
       </x-dashboard.content>
    </section>
@endsection 