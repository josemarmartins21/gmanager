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
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </x-slot:thead>

                    <x-slot:body>
                        @foreach ($sales as $sale)
                            <tr class="hover:bg-gray-100 dark:hover:bg-[var(--dark-fundo-card)]">
                                <td><x-dashboard.price-format :value="$sale->total" /></td>
                                <td><x-dashboard.price-format :value="$sale->total_payed" /></td>
                                <td>{{ $sale->name }}</td>
                                <td>{{ $sale->created_at->format('d/m/Y') }}</td>

                                <td class="flex justify-center gap-5 items-center">
                                    <form action="{{ route('sale-status', $sale->id) }}" method="POST">
                                        @csrf

                                        @method('PATCH')

                                        <button type="submit"
                                            @class([
                                                'bg-green-700' => $sale->status, 
                                                'bg-red-700' => ! $sale->status,
                                                'px-4 py-2 rounded-[5px] text-white font-semibold hover:opacity-80 transition-opacity duration-300 transition transform active:scale-[0.95] duration-300'
                                            ])
                                            title="{{ $sale->status ? 'Marcar como não paga' : 'Marcar como paga' }}"
                                            onclick="return confirm('Tem certeza que deseja alterar o status da venda?')"
                                        >
                                            {{ $sale->status ? 'Paga' : 'Não Paga' }}
                                        </button>
                                    </form>
                                    
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
    >
        <i class="fa-solid fa-plus text-2xl"></i>
    </x-dashboard.float-btn> 

    <x-dashboard.modal >
        <x-dashboard.actions-container>
            <x-dashboard.action-card>
                <x-slot:type>
                    <a href="{{ route('sales.create') }}"
                    title="Nova Venda"
                >
                        <i class="fa-solid fa-plus text-3xl"></i>
                    </a>
                </x-slot:type>
            </x-dashboard.action-card>
            
            <x-dashboard.action-card>
                <x-slot:type>
                    <a href="{{ route('pdfs.download', ['typePdf' => 'sales']) }}"
                        title="Exportar em PDF"    
                    >
                        <i class="fa-solid fa-file-pdf text-3xl"></i>
                    </a>
                </x-slot:type>
            </x-dashboard.action-card>
        </x-dashboard.actions-container>
    </x-dashboard.modal>
@endsection 