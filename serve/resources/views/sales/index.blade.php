@extends('layouts.main')

@section('title', 'GManager - Vendas')
@section('section', 'Vendas')

@section('content')
    <x-dashboard.alert />
    <section id="index-container">
               <x-dashboard.content>
            <x-dashboard.title-section>
                Vendas
            </x-dashboard.title-section>

            <x-dashboard.main-table class="md:mb-4">
                <x-dashboard.table>
                    <x-slot:thead>
                        <tr>
                            <th>Total</th>
                            <th>Total Pago</th>
                            <th>Responsável</th>
                            <th>Estado</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </x-slot:thead>

                    <x-slot:body>
                        @foreach ($sales as $sale)
                            <tr class="hover:bg-gray-100 dark:hover:bg-[var(--dark-fundo-card)]">
                                <td>{{ $sale->total }}</td>
                                <td>{{ $sale->total_payed }}</td>
                                <td>{{ $sale->name }}</td>
                                <td @class(['text-green-600' => $sale->status, 'text-red-600' => ! $sale->status])>
                                    {{ $sale->status ? 'Pago' : 'Não Pago' }}
                                </td>
                                <td>{{ $sale->created_at }}</td>

                                <td class="flex justify-center">
                                    <form action="{{ route('sales.destroy', $sale->id) }}" method="POST">
                                        @csrf
                                        
                                        @method('DELETE')

                                        <x-dashboard.action-btn onclick="return confirm('Excluir venda?')" class="bg-red-700">
                                                <i class="fa-solid fa-trash text-xl"></i>
                                            </x-dashboard.action-btn>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </x-slot:body>
                </x-dashboard.table>
            </x-dashboard.main-table>
            {{ $sales->links() }}
       </x-dashboard.content>
    </section>

    <x-dashboard.float-btn 
        class="bg-blue-600 bottom-8" 
        onclick="abrirModal()"
        type="a"
    >
        <i class="fa-solid fa-plus text-2xl"></i>
    </x-dashboard.float-btn> 

    <x-dashboard.modal >
        <x-dashboard.actions-container>
            <x-dashboard.action-card>
                <i class="fa-solid fa-plus text-3xl"></i>

                <x-slot:type>
                    <a href="{{ route('sales.create') }}">Nova Venda</a>
                </x-slot:type>
            </x-dashboard.action-card>
            
            <x-dashboard.action-card>
                <i class="fa-solid fa-file-export text-3xl"></i>

                <x-slot:type>
                    <a href="{{ route('pdfs.download', ['typePdf' => 'sales']) }}">Exportar</a>
                </x-slot:type>
            </x-dashboard.action-card>
        </x-dashboard.actions-container>
    </x-dashboard.modal>
@endsection 