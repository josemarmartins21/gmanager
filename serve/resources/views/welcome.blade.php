@extends('layouts.main')  

@section('title', 'Dashboard')
@section('section', 'Dashboard')

@section('content')
        <x-dashboard.content>
            <x-dashboard.overview>
            <x-slot:title>Resumo Rápido</x-slot:title>

                <x-dashboard.cards-overview>    
                    <x-dashboard.card-overview>
                        <span>Total de Assinaturas</span>
                        <h3 class="text-3xl"></h3>
                        <p>Total de assinaturas activa</p>
                    </x-dashboard.card-overview>
                    
                    <x-dashboard.card-overview>
                        <span>Município Mais Activo</span>
                            <h3 class="text-3xl">
                                
                            </h3>
                            <p>
                                Total de clientes 
                                
                            </p>
                        </x-dashboard.card-overview>
                        
                        <x-dashboard.card-overview>
                            <span>Receita Total</span>
                            <h3 class="text-3xl">Kz</h3>
                            <p>Receita total do mês</p>
                        </x-dashboard.card-overview>
                </x-dashboard.cards-overview>
            </x-dashboard.overview>
        </x-dashboard.content>

        <x-dashboard.fast-checkout>
            <x-dashboard.raking 
                description="Top 3 Planos mais assinado"
                title="Planos em alta"
            >
                
            </x-dashboard.raking>
        </x-dashboard.fast-checkout>
    </section>
@endsection