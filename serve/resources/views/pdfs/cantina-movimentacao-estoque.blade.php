@use('App\Helpers\DateHelper')

{{--
  Lista de Produtos — Cantina
  Documento filho que estende o layout institucional partilhado (mesma
  direcção de arte da Declaração de Matrícula: cabeçalho, tipografia
  Times New Roman/DejaVu Serif, paleta #1c3a5e, rodapé institucional).
  Ajusta o caminho do @extends abaixo para o nome real do teu layout base.

  Convenção: texto em MAIÚSCULAS é placeholder visual, a substituir por
  variáveis Blade/PHP (ex.: {{ $produto->descricao }}) numa etapa posterior.

  IMPORTANTE: este ficheiro só define os blocos de conteúdo. A classe CSS
  "table.tabela-produtos" usada abaixo ainda não existe no layout base —
  adiciona o bloco de CSS no final deste ficheiro à <style> do teu layout
  partilhado (fica bem ao lado dos outros blocos "table.extracto" /
  "table.salario", segue a mesma convenção de nomenclatura).
--}}
@extends('layouts.pdf-base')

@section('title', 'Movimentações de Estoque')

@section('details')
    {{ date('d/m/Y') }}
@endsection

@section('content')

    <div class="secao-titulo">Estoque Actual</div>

    <table class="tabela-produtos">
        <thead>
            <tr>
                <th>Descrição</th>
                <th>Responsável</th>
                <th>Tipo de Mov.</th>
                <th>Total Uni.</th>
                <th>Nª de Caixas</th>
                <th>Preço da Caixa</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            @php
                $stockMovements = $data;
                $totalStockValue = 0;
            @endphp

            @foreach ($stockMovements as $stockMovement)
                @php
                    $totalStockValue += $stockMovement->current_stock * $stockMovement->prod_unit_price;
                @endphp

                <tr>
                    <td class="col-produto">{{ $stockMovement->product_name }}</td>
                    <td class="col-produto">{{ $stockMovement->name }}</td>
                    <td class="col-produto">{{ $stockMovement->type  }}</td>
                    <td class="col-stock">{{ $stockMovement->total_units }}</td>
                    <td class="col-stock">{{ $stockMovement->box_qty  }}</td>
                    <td class="col-preco-caixa"><x-dashboard.price-format :value="$stockMovement->prod_box_price" /></td>
                    <td class="col-produto"> {{ date('d/m/Y') }} <td>
                </tr>

                @if ($loop->index === 9)
                    @break {{-- Limita a exibição a 10 linhas --}}
                @endif
            @endforeach

            <tr class="linha-total">
                <td colspan="6">Valor Total em Estoque</td>
                <td class="valor-monetario">KZ {{ number_format($totalStockValue, 2, ',', '.') }}Kz</td>
            </tr>
        </tbody>
    </table>

    <p class="legenda">
        <strong>Nota:</strong> os valores apresentados reflectem o preço da
        caixa conforme a tabela de custos vigente à data de emissão deste
        relatório.
    </p>

@endsection

{{--
=========================================================
CSS A ADICIONAR AO LAYOUT BASE (dentro da <style> partilhada)
=========================================================

table.tabela-produtos {
    width: 100%;
    border-collapse: collapse;
    margin: 2mm 0 4mm 0;
    font-size: 9.3pt;
    page-break-inside: avoid;
}
table.tabela-produtos th {
    background: #eef1f4;
    color: #1c3a5e;
    font-family: Arial, Helvetica, "DejaVu Sans", sans-serif;
    font-size: 8pt;
    text-transform: uppercase;
    letter-spacing: 0.4pt;
    font-weight: bold;
    padding: 1.8mm 2.5mm;
    border: 0.75pt solid #c7cdd4;
}
table.tabela-produtos td {
    padding: 1.6mm 2.5mm;
    border: 0.75pt solid #c7cdd4;
}
table.tabela-produtos th:nth-child(1),
table.tabela-produtos td:nth-child(1) { width: 46%; text-align: left; }
table.tabela-produtos th:nth-child(2),
table.tabela-produtos td:nth-child(2) { width: 18%; text-align: center; }
table.tabela-produtos th:nth-child(3),
table.tabela-produtos td:nth-child(3),
table.tabela-produtos th:nth-child(4),
table.tabela-produtos td:nth-child(4) { width: 18%; text-align: right; }
table.tabela-produtos tr.linha-total td {
    font-weight: bold;
    background: #f7f8f9;
    border-top: 1.2pt solid #1c3a5e;
}
--}}
