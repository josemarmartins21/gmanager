@use('App\Helpers\DateHelper')
@extends('layouts.main')

@section('title', 'GManager - Movimentação de Estoque')
@section('section', 'Gestão de Estoque')

<x-dashboard.alert />
@section('content')
    <section id="index-container">
            <x-dashboard.content>
            <x-dashboard.title-section>
                Gestor de Estoque
            </x-dashboard.title-section>

            <x-dashboard.main-table class="md:mb-4">
                <x-dashboard.table>
                    <x-slot:thead>
                        <tr>
                            <th>Descrição</th>
                            <th>Tipo de Mov.</th>
                            <th>Total Uni.</th>
                            <th>Nª de Caixas</th>
                            <th>Preço da Caixa</th>
                            <th>Responsável</th>
                            <th colspan="3">Data</th>
                            <th>Ações</th>
                        </tr>
                    </x-slot:thead>

                    <x-slot:body>
                        @foreach ($stockMovements as $stockMovement)
                            <tr>
                                <td>{{ $stockMovement->product_name }}</td>
                                <td @class([
                                    'font-bold' => true,
                                    'text-yellow-700' => strtolower($stockMovement->type) == 'reajuste', 
                                    'text-red-700' => strtolower($stockMovement->type) == 'perda',
                                    'text-green-700' => strtolower($stockMovement->type) == 'entrada',
                                ])>{{ $stockMovement->type }}</td>
                                <td>{{ $stockMovement->total_units }}</td>
                                <td>{{ $stockMovement->box_qty }}</td>
                                <td><x-dashboard.price-format :value="$stockMovement->box_price" /></td>
                                <td> {{ $stockMovement->name }}<td>
                                <td> {{ $stockMovement->created_at->format('d/m/Y') }}<td>

                                <td>
                                    <form action="{{ route('stock-movements.destroy', $stockMovement->id) }}" method="POST" class="iniline">
                                        @csrf

                                        @method('Delete')

                                        <x-dashboard.action-btn onclick="return confirm('Tem a certeza que pretende eliminar?')" class="bg-red-700">
                                            <i class="fa-solid fa-trash text-xl"></i>
                                        </x-dashboard.action-btn>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </x-slot:body>
                </x-dashboard.table>
            </x-dashboard.main-table>
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
                    <a  href="{{ route('stock-movements.create') }}"
                    title="Nova Movimentação de Stock"
                >
                        <i class="fa-solid fa-plus text-3xl"></i>
                    </a>
                </x-slot:type>
            </x-dashboard.action-card>
            
            <x-dashboard.action-card>
                <x-slot:type>
                    <a href="{{ route('pdfs.download', ['typePdf' => 'cantina-movimentacao-estoque']) }}"
                        title="Exportar em PDF"    
                    >
                        <i class="fa-solid fa-file-pdf text-3xl"></i>
                    </a>
                </x-slot:type>
            </x-dashboard.action-card>
        </x-dashboard.actions-container>
    </x-dashboard.modal>
@endsection 