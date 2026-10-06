@extends('layouts.main')  
@use('App\Models\Sale')

@section('title', 'Página Inicial')
@section('section', 'Página Inicial')

@section('content')
        <x-dashboard.content>
            <x-dashboard.overview>
            <x-slot:title>Resumo Rápido</x-slot:title>

                <x-dashboard.cards-overview>    
                    <x-dashboard.card-overview>
                        <p>Facturação do mês</p>
                        <h3 class="md:text-3xl"><x-dashboard.price-format :value="$financial['revenue']"/></h3>
                        <span class="text-zinc-400">{{ Sale::payedThisMonth(true)->count() }} vendas</span>
                    </x-dashboard.card-overview>
                    
                    <x-dashboard.card-overview>
                            <p>
                                Total recebido
                                
                            </p>
                            <h3 class="md:text-3xl">
                                <x-dashboard.price-format :value="$financial['received']"/>
                            </h3>
                        </x-dashboard.card-overview>
                        
                        <x-dashboard.card-overview>
                            <p>Valores por receber</p>
                            <h3 class="md:text-3xl">
                                <x-dashboard.price-format :value="$financial['pending']"/>
                            </h3>    
                            <span class="text-red-700">{{ Sale::payedThisMonth(false)->where('total', '<', 25000)->count() }} vendas pendentes</span>
                        </x-dashboard.card-overview>
                </x-dashboard.cards-overview>
            </x-dashboard.overview>
        </x-dashboard.content>

        <x-dashboard.fast-checkout>

                
    
            <x-dashboard.raking 
                description="Top 3 bebidas mais vendidas"
                title="Bebidas em alta"
                :items="$topProducts"
            />
        </x-dashboard.fast-checkout>
    </section>
@endsection