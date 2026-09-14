@extends('layouts.main')

@section('title', 'GManager - Nova Venda')
@section('section', 'Nova Venda')

@section('content')
<x-dashboard.alert />

    <section id="index-container" class="md:grid md:grid-cols-[5fr_2fr]">
       <div class="md:bg-white md:dark:bg-[var(--dark-fundo-card)] rounded-xl  m-5  lg:m-[0px_10px_0px_10px]">
            <x-dashboard.main-table class="md:mb-4">
                <x-dashboard.table>
                    <x-slot:thead>
                        <tr>
                            <th>Producto</th>
                            <th>Preço</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Ação</th>
                        </tr>
                    </x-slot:thead>

                    <x-slot:body>
                        @if (session('sale.cart') !== null)
                            @foreach (session('sale.cart') as $item)
                                <tr class="hover:bg-gray-100 dark:hover:bg-[var(--dark-fundo-card)]">
                                    <td>{{ $item['product_name'] }}</td>
                                    <td>{{   number_format($item['product_price'], 2, ',', '.')}}Kz</td>
                                    <td>{{ $item['qty'] }}</td>
                                    <td>{{ number_format($item['qty'] * $item['product_price'], 2, ',', '.') }}Kz</td>
                                    <td class="flex justify-center">
                                        <form action="{{ route('sale-items.destroy') }}" method="POST">
                                            @csrf

                                            <input type="hidden" name="id" value="{{ $item['product_id'] }}">

                                            <button type="submit" onclick="return confirm('Excluir da venda')">
                                                <i class="fa-solid text-2xl fa-trash text-red-600"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif   
                    </x-slot:body>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-left text-2xl font-bold">Total:</th>

                            <th colspan="2" class="text-center font-bold">
                                @php
                                    $total = 0;
                                @endphp

                                @if (session('sale.cart') !== null)
                                    @foreach (session('sale.cart') as $item)
                                        @php
                                            $total += $item['qty'] * $item['product_price'];
                                        @endphp
                                    @endforeach
                                @endif

                                {{ number_format($total, 2, ',', '.') }}Kz
                            </th>
                        </tr>
                    </tfoot>
                </x-dashboard.table>
            </x-dashboard.main-table>
        </div>

       <div class="md:bg-white md:dark:bg-[var(--dark-fundo-card)] rounded-xl  m-5  lg:m-[0px_10px_0px_10px] md:p-3">
            <x-dashboard.title-form class="pb-3">
                <x-slot:title>Producto a ser Vendido</x-slot:title>
                <x-slot:disclaimer>
                    Os campos obrigatórios estão marcados com *
                </x-slot:disclaimer>
            </x-dashboard.title-form>

            <form 
                method="POST" 
                action="{{ route('sale-items.store') }}"
            >
                @csrf

                <x-dashboard.input-container>
                    <x-dashboard.form-label for="product_id">
                        Producto
                    </x-dashboard.form-label>
                
                    <x-dashboard.input-select name="product_id">
                        <option value="" selected>Selecione um Item *</option>
                        @foreach ($products as $product)
                            <option 
                                value="{{ $product->id }}" 
                                {{ old('product_id') == $product->id ? 'selected' : '' }}
                            > 
                                {{ $product->name }} - {{ number_format($product->price, 2, ',', '.') }}Kz
                            </option>
                        @endforeach
                    </x-dashboard.input-select>
                    <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
                </x-dashboard.input-container>

            <x-dashboard.input-container>
                <x-dashboard.form-label for="qty">
                    Quantidade
                </x-dashboard.form-label>

                <x-dashboard.form-input type="number" value="{{ old('qty') }}" name="qty" id="qty" placeholder="Quantidade *" min="1"></x-dashboard.form-input>
                <x-input-error :messages="$errors->get('qty')" class="mt-2" />
            </x-dashboard.input-container>

            <x-dashboard.input-container class="mt-5">
                <button class="rounded-xl p-2  md:text-white bg-blue-600 font-bold cursor-pointer active:scale-[0.98] w-full inline-block sm:inline"  type="submit">
                    Cadastrar
                </button>
            </x-dashboard.input-container>
            </form>

            <div class="flex flex-col gap-3 mt-5">
                <x-dashboard.input-container>
                    <button class="rounded-xl p-2  md:text-white bg-green-600 font-bold cursor-pointer active:scale-[0.98] w-full inline-block sm:inline" onclick="abrirModal()">
                        Finalizar a Venda
                    </button>
                </x-dashboard.input-container>
                
            
                <form action="{{ route('sale-items.removeAll') }}" method="POST">
                    @csrf
                    <x-dashboard.input-container>
                        <button onclick="return confirm('Esvaziar carrinho')" class="rounded-xl p-2  md:text-white bg-red-700 font-bold cursor-pointer active:scale-[0.98] w-full inline-block sm:inline"  type="submit">
                            Limpar Carrinho
                        </button>
                    </x-dashboard.input-container>
                </form>
                
            </div>
       </div>
    </section>
    <x-dashboard.modal>
        <x-dashboard.title-form class="pb-3">
            <x-slot:title>Finalizar Venda</x-slot:title>
            <x-slot:disclaimer>
                Os campos obrigatórios estão marcados com *
            </x-slot:disclaimer>
        </x-dashboard.title-form>

         <x-dashboard.form-container 
                method="POST" 
                action="{{ route('sales.store') }}"
            >

            <x-dashboard.input-container>
                <x-dashboard.form-label for="name">
                    Nota
                </x-dashboard.form-label>

                <x-dashboard.form-input-text type="text" name="note" id="note" placeholder="Nota">
                    {{ old('note') }}
                </x-dashboard.form-input-text>

                <x-input-error :messages="$errors->get('note')" class="mt-2" />
                </x-dashboard.input-container>

            <x-dashboard.input-container>
                <x-dashboard.form-label for="price">
                    Total Pago
                </x-dashboard.form-label>

                <x-dashboard.form-input type="number" value="{{ old('total_payed') }}" name="total_payed" id="total_payed" placeholder="Total Pago *"></x-dashboard.form-input>
                
                <x-input-error :messages="$errors->get('total_payed')" class="mt-2" />
            </x-dashboard.input-container>
           
            <x-dashboard.input-container>
              <x-dashboard.form-btn>
                    Finalizar
                </x-dashboard.form-btn>
            </x-dashboard.input-container>
            </x-dashboard.form-container>
    </x-dashboard.modal>
@endsection  