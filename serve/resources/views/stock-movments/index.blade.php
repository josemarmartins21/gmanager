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
                            <th>Total Uni.</th>
                            <th>Nª de Caixas</th>
                            <th>Tipo de Mov.</th>
                            <th>Preço da Caixa</th>
                            <th>Responsável</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </x-slot:thead>

                    <x-slot:body>
                        @foreach ($stockMovements as $stockMovement)
                            <tr class="hover:bg-gray-100 dark:hover:bg-[var(--dark-fundo-card)]">
                                <td>{{ $stockMovement->product_name }}</td>
                                <td>{{ $stockMovement->total_units }}</td>
                                <td>{{ $stockMovement->box_qty }}</td>
                                <td>{{ $stockMovement->type }}</td>
                                <td>{{ $stockMovement->box_price }}</td>
                                <td> {{ $stockMovement->name }}<td>
                                <td> {{ DateHelper::diffForHumans($stockMovement->created_at) }}<td>

                                <td class="flex justify-between">
                                    <x-dashboard.action-btn 
                                        type="link" 
                                        class="bg-green-700"
                                        href="{{ route('stock-movements.edit', $stockMovement->id) }}"
                                    >
                                        <i class="fa-solid fa-edit text-xl"></i>
                                    </x-dashboard.action-btn>
    
                                    <form action="{{ route('stock-movements.destroy', $stockMovement->id) }}" method="POST" >
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
        <i class="fa-solid fa-plus text-2xl"></i>
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
                    <a href="{{ route('pdfs.download', ['typePdf' => 'stock-movements']) }}"
                        title="Exportar em PDF"    
                    >
                        <i class="fa-solid fa-file-pdf text-3xl"></i>
                    </a>
                </x-slot:type>
            </x-dashboard.action-card>
        </x-dashboard.actions-container>
    </x-dashboard.modal>
@endsection 