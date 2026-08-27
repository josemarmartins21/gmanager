{{--
    GManager — Hamburgueria G. Wey Carter
    View: Lista de Produtos (PDF institucional)

    Geração: barryvdh/laravel-dompdf
    Exemplo de uso no controller:
        $pdf = Pdf::loadView('pdf.lista-produtos', ['products' => $products]);
        return $pdf->stream('lista-produtos.pdf');

    Nesta versão os dados da tabela são placeholders fictícios.
    Ver comentário dentro do <tbody> com o bloco @foreach para a
    substituição futura pelos dados reais.
--}}
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Lista de Produtos - GManager</title>
<style>

    /* ==========================================================
       1. CONFIGURAÇÃO DA PÁGINA (DOMPDF)
       ========================================================== */
    @page {
        size: A4;
        margin: 20mm 15mm 32mm 15mm; /* topo direita baixo esquerda */
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: "Helvetica", "Arial", sans-serif;
        font-size: 11pt;
        color: #2b2b2b;
        line-height: 1.4;
        background-color: #ffffff;
    }

    .content-wrapper {
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
        padding: 0 10px;
    }

    /* ==========================================================
       2. CABEÇALHO INSTITUCIONAL
       ========================================================== */
    .header {
        border-bottom: 2px solid #2b2b2b;
        padding-bottom: 12px;
        margin-bottom: 20px;
    }

    .header .system-name {
        font-size: 10pt;
        font-weight: bold;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #555555;
    }

    .header .establishment-name {
        font-size: 16pt;
        font-weight: bold;
        color: #1a1a1a;
        margin-top: 2px;
        margin-bottom: 14px;
    }

    .header .document-title {
        font-size: 14pt;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #1a1a1a;
    }

    .header .document-subtitle {
        font-size: 9.5pt;
        color: #666666;
        margin-top: 2px;
    }

    .header .issue-date {
        font-size: 9pt;
        color: #444444;
        margin-top: 10px;
    }

    /* ==========================================================
       3. CONTEÚDO / TABELA
       ========================================================== */
    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    table.products-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 9.5pt;
    }

    table.products-table thead {
        display: table-header-group; /* repete o cabeçalho da tabela em cada página */
    }

    table.products-table tbody {
        display: table-row-group;
    }

    table.products-table tr {
        page-break-inside: avoid; /* evita dividir uma linha de produto entre páginas */
    }

    table.products-table th {
        background-color: #2b2b2b;
        color: #ffffff;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 8.5pt;
        letter-spacing: 0.3px;
        padding: 8px 6px;
        border: 1px solid #2b2b2b;
        text-align: left;
    }

    table.products-table td {
        padding: 7px 6px;
        border: 1px solid #d9d9d9;
        color: #2b2b2b;
        word-wrap: break-word;
    }

    table.products-table tbody tr:nth-child(even) {
        background-color: #f5f5f5;
    }

    /* Larguras das colunas */
    .col-produto     { width: 30%; }
    .col-categoria   { width: 17%; }
    .col-stock       { width: 15%; }
    .col-preco       { width: 18%; }
    .col-preco-caixa { width: 20%; }

    /* Alinhamento das colunas numéricas */
    th.col-stock, th.col-preco, th.col-preco-caixa,
    td.col-stock, td.col-preco, td.col-preco-caixa {
        text-align: right;
    }

    /* ==========================================================
       4. RODAPÉ INSTITUCIONAL (fixo em todas as páginas)
       ========================================================== */
    footer {
        position: fixed;
        bottom: -24mm;
        left: 0;
        right: 0;
        height: 20mm;
        border-top: 1px solid #cccccc;
        padding-top: 6px;
        text-align: center;
    }

    footer .footer-institution {
        font-size: 8.5pt;
        color: #555555;
        font-weight: bold;
    }

    footer .footer-developer {
        font-size: 7.5pt;
        color: #999999;
        margin-top: 2px;
    }

    footer .footer-page {
        font-size: 7.5pt;
        color: #999999;
        margin-top: 2px;
    }

    .footer-page:before {
        content: "Página " counter(page) " de " counter(pages);
    }

    /* ==========================================================
       5. RESPONSIVIDADE (pré-visualização em ecrã)

       NOTA TÉCNICA: o valor por omissão de "default_media_type" no
       DOMPDF é "screen". Por isso os breakpoints abaixo usam valores
       propositadamente baixos (≤480px), sempre inferiores à largura
       útil de uma página A4 (≈680px após margens), para nunca serem
       acionados durante a geração do PDF. Para reforçar ainda mais a
       compatibilidade, pode definir 'default_media_type' => 'print'
       em config/dompdf.php.
       ========================================================== */
    @media screen and (max-width: 480px) {
        .content-wrapper { max-width: 100%; padding: 0 12px; }
        table.products-table { font-size: 8.5pt; }
        table.products-table th,
        table.products-table td { padding: 6px 4px; }
        .header .establishment-name { font-size: 13pt; }
        .header .document-title { font-size: 11.5pt; }
    }

    @media screen and (max-width: 360px) {
        table.products-table { font-size: 7.5pt; }
        table.products-table th,
        table.products-table td { padding: 5px 3px; }
        .header .establishment-name { font-size: 12pt; }
        .header .document-title { font-size: 10.5pt; }
        .header .document-subtitle { font-size: 8pt; }
    }

    /* ==========================================================
       6. ESTILOS DE IMPRESSÃO
       ========================================================== */
    @media print {
        .table-wrapper { overflow: visible; }
    }

</style>
</head>
<body>

<div class="content-wrapper">

    {{-- ===================== CABEÇALHO ===================== --}}
    <header class="header">
        <div class="system-name">GManager</div>
        <div class="establishment-name">Hamburgueria G. Wey Carter</div>
        <div class="document-title">Lista de Produtos</div>
        <div class="document-subtitle">Relação de produtos e respetivos valores comerciais</div>
        <div class="issue-date">Data de emissão: {{ date('d/m/Y')}}</div>
    </header>

    {{-- ===================== TABELA DE PRODUTOS ===================== --}}
    <div class="table-wrapper">
        <table class="products-table">
            <thead>
                <tr>
                    <th class="col-produto">Produto</th>
                    <th class="col-categoria">Categoria</th>
                    <th class="col-stock">Qtd. em Stock</th>
                    <th class="col-preco">Preço Unitário</th>
                    <th class="col-preco-caixa">Preço p/ Caixa</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $products = $data;

                @endphp
                @foreach ($products as $product)
                    <tr>
                        <td class="col-produto">{{ $product->name }}</td>
                        <td class="col-categoria">{{ $product->category_name }}</td>
                        <td class="col-stock">{{ $product->current_stock }}</td>
                        <td class="col-preco">{{ number_format($product->price, 2, ',', '.') }} Kz</td>
                        <td class="col-preco-caixa">{{ number_format($product->box_price, 2, ',', '.') }} Kz</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

{{-- ===================== RODAPÉ ===================== --}}
<footer>
    <div class="footer-institution">GManager — Hamburgueria G. Wey Carter</div>
    <div class="footer-developer">Desenvolvido por Josemar Dev</div>
    <div class="footer-page"></div>
</footer>

</body>
</html>
