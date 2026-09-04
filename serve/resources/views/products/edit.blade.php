@extends('layouts.main')

@section('title', 'GManager - Productos')
@section('section', 'Productos')

@section('content')
<x-dashboard.alert />

    <section id="index-container">
       <x-dashboard.content class="md:bg-white md:dark:bg-[var(--dark-fundo-card)] md:p-5">
            <x-dashboard.title-form class="pb-3">
                <x-slot:title>Novo Producto</x-slot:title>
                <x-slot:disclaimer>
                    Os campos obrigatórios estão marcados com *
                </x-slot:disclaimer>
            </x-dashboard.title-form>

            <x-dashboard.form-container 
                method="POST" 
                action="{{ route('products.update', $product->id) }}"
            >
            @method('PUT')

            <x-dashboard.input-container>
                <x-dashboard.form-label for="name">
                    Nome
                </x-dashboard.form-label>

                <x-dashboard.form-input type="text" value="{{ old('name', $product->name) }}" name="name" id="name" placeholder="Nome *"></x-dashboard.form-input>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </x-dashboard.input-container>

            <x-dashboard.input-container>
                <x-dashboard.form-label for="price">
                    Preço
                </x-dashboard.form-label>

                <x-dashboard.form-input type="number" value="{{ old('price', $product->price) }}" name="price" id="price" placeholder="Preço do producto *"></x-dashboard.form-input>
                <x-input-error :messages="$errors->get('price')" class="mt-2" />
            </x-dashboard.input-container>
           
            <x-dashboard.input-container>
                <x-dashboard.form-label for="box_price">
                    Preço da Caixa(Grade)
                </x-dashboard.form-label>

                <x-dashboard.form-input type="number" value="{{ old('box_price', $product->box_price) }}" name="box_price" id="box_price" placeholder="Preço da caixa(Grade) *" min="500"></x-dashboard.form-input>

                <x-input-error :messages="$errors->get('box_price')" class="mt-2" />
            </x-dashboard.input-container>
                
            <x-dashboard.input-container>
                <x-dashboard.form-label for="min_stock">
                    Estoque Mínimo
                </x-dashboard.form-label>

                <x-dashboard.form-input type="number" value="{{ old('min_stock', $product->min_stock) }}" name="min_stock" id="min_stock" placeholder="Número mínimo de estoque *"></x-dashboard.form-input>
                <x-input-error :messages="$errors->get('min_stock')" class="mt-2" />
            </x-dashboard.input-container>

            <x-dashboard.input-container>
                <x-dashboard.form-label for="bairro_id">
                    Categoria
                </x-dashboard.form-label>
            
                <x-dashboard.input-select name="category_id">
                    <option value="" selected>Selecione uma Categoria *</option>
                    @foreach ($categories as $category)
                        <option 
                            value="{{ $category->id }}" 
                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}
                        > 
                            {{ $category->name }} 
                        </option>
                    @endforeach
                </x-dashboard.input-select>
                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
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