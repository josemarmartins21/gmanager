@extends('layouts.main')

@section('title', 'GManager - Movimentação de Estoque')
@section('section', 'Movimentação de Estoque')

@section('content')
<x-dashboard.alert />
    <section id="index-container">
       <x-dashboard.content class="md:bg-white md:dark:bg-[var(--dark-fundo-card)] md:p-5">
            <x-dashboard.title-form class="pb-3">
                <x-slot:title>Movimentação de Estoque</x-slot:title>
                <x-slot:disclaimer>
                    Os campos obrigatórios estão marcados com *
                </x-slot:disclaimer>
            </x-dashboard.title-form>

            <x-dashboard.form-container 
            method="POST" 
            action="{{ route('stock-movements.update', $stockMovement->id) }}"
            >
            @method('Put')
            
            <x-dashboard.input-container>
                <x-dashboard.form-label for="product_id">
                    Producto
                </x-dashboard.form-label>
                
                <x-dashboard.input-select name="product_id">
                    <option value="" selected>Selecione uma Producto *</option>
                    @foreach ($products as $product)
                        <option 
                        value="{{ $product->id }}" 
                        {{ old('product_id', $stockMovement->product_id) == $product->id ? 'selected' : '' }}
                        > 
                        {{ $product->name }} 
                        </option>
                    @endforeach
                </x-dashboard.input-select>

            <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
            </x-dashboard.input-container>

            <x-dashboard.input-container>
                <x-dashboard.form-label for="type">
                    Tipo de Operação
                </x-dashboard.form-label>
                
                <x-dashboard.input-select name="type">
                    <option value="" selected>Selecione um Tipo de Operação de Estoque *</option>
                    @foreach ($allowedOperations as $operations)
                        <option 
                        value="{{ $operations->value }}" 
                        {{ old('type', $stockMovement->type) == $operations->value ? 'selected' : '' }}
                        > 
                        {{ $operations->value }} 
                        </option>
                    @endforeach
                </x-dashboard.input-select>

            <x-input-error :messages="$errors->get('type')" class="mt-2" />
            </x-dashboard.input-container>

            <x-dashboard.input-container>
                <x-dashboard.form-label for="box_price">
                    Preço da Caixa(Grade)
                </x-dashboard.form-label>

                <x-dashboard.form-input type="number" value="{{ old('box_price', $stockMovement->box_price) }}" name="box_price" id="box_price" placeholder="Preço da caixa(Grade) *"></x-dashboard.form-input>
                <x-input-error :messages="$errors->get('box_price')" class="mt-2" />
            </x-dashboard.input-container>

            <x-dashboard.input-container>
                <x-dashboard.form-label for="total_units">
                    Quantidade Total
                </x-dashboard.form-label>
                
                <x-dashboard.form-input type="number" value="{{ old('total_units', $stockMovement->total_units ? $stockMovement->total_units : '') }}" name="total_units" id="total_units" placeholder="Quantidade *"></x-dashboard.form-input>
                <x-input-error :messages="$errors->get('total_units')" class="mt-2" />
            </x-dashboard.input-container>
                
            <x-dashboard.input-container>
                <x-dashboard.form-label for="units_per_box">
                    Total de unidades por caixa
                </x-dashboard.form-label>

                <x-dashboard.form-input type="number" value="{{ old('units_per_box', $stockMovement->units_per_box ? $stockMovement->units_per_box : '') }}" name="units_per_box" id="units_per_box" placeholder="Total em cada caixa *" ></x-dashboard.form-input>
                <x-input-error :messages="$errors->get('units_per_box')" class="mt-2" />
            </x-dashboard.input-container>

            <x-dashboard.input-container>
                <x-dashboard.form-label for="box_qty">
                    Nª de Caixas
                </x-dashboard.form-label>

                <x-dashboard.form-input type="number" value="{{ old('box_qty', $stockMovement->box_qty ? $stockMovement->box_qty : '') }}" name="box_qty" id="box_qty" placeholder="Nª de Caixas/Grade"></x-dashboard.form-input>
                <x-input-error :messages="$errors->get('box_qty')" class="mt-2" />
            </x-dashboard.input-container>

            
            <x-dashboard.input-container>
                <x-dashboard.form-label for="name">
                    Nota
                </x-dashboard.form-label>

                <x-dashboard.form-input-text type="text" name="note" id="note" placeholder="Nota">
                    {{ old('note', $stockMovement->note) }}
                </x-dashboard.form-input-text>

                <x-input-error :messages="$errors->get('note')" class="mt-2" />
            </x-dashboard.input-container>
           
            <x-dashboard.input-container>
              <x-dashboard.form-btn>
                    Actualizar
                </x-dashboard.form-btn>
            </x-dashboard.input-container>
            </x-dashboard.form-container>
       </x-dashboard.content>
    </section>
@endsection  