@php
    /*
     * FACTURA DE VENDA — ajustada ao esquema actual das tabelas
     *
     * Variáveis esperadas:
     *   $sale  : modelo Sale com id, total, total_payed, note, user_id,
     *            created_at, deleted_at
     *   $sale->items : itens da venda (modelo SaleItem) com qty, product_id,
     *                  product_name, product_price, subtotal
     *
     * Não aparecem neste documento os campos que o esquema não tem
     * (cliente, NIF, impostos, desconto, dados bancários, valor por extenso).
     */

    $sale = $data;
    $kz = fn ($valor) => number_format((float) ($valor ?? 0), 2, ',', '.');

    $numero = str_pad($sale->id, 6, '0', STR_PAD_LEFT);
    $emitidaEm = \Illuminate\Support\Carbon::parse($sale->created_at);
    $anulada = ! is_null($sale->deleted_at);
    $anuladaEm = $anulada ? \Illuminate\Support\Carbon::parse($sale->deleted_at) : null;

    $items = $sale->saleItems ?? collect();
    $totalItens = count($items);
    $subtotal = collect($items)->sum(fn ($item) => (float) $item->subtotal);
    $total = (float) $sale->total;
    $totalPago = (float) $sale->total_payed;
    $saldo = max($total - $totalPago, 0);

    if ($totalPago <= 0) {
        $estadoPagamento = 'Por pagar';
    } elseif ($totalPago < $total) {
        $estadoPagamento = 'Parcialmente paga';
    } else {
        $estadoPagamento = 'Paga';
    }
@endphp
<!DOCTYPE html>
<html lang="pt-AO">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Factura {{ $numero }}</title>
<style>

  /* ---------- Configuração da página (A4 / impressão / DOMPDF) ---------- */
  @page {
      size: A4 portrait;
      margin: 20mm;
  }

  * { box-sizing: border-box; }

  html, body {
      margin: 0;
      padding: 30px;
      background: #ffffff;
      color: #1a1a1a;
      font-family: "Times New Roman", Times, "DejaVu Serif", serif;
      font-size: 10.5pt;
      line-height: 1.5;
  }

  /* ---------- Cabeçalho ---------- */
  table.cabecalho {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 3mm;
      page-break-inside: avoid;
  }
  table.cabecalho td { vertical-align: top; padding: 0; }

  .empresa-nome {
      font-family: Arial, Helvetica, "DejaVu Sans", sans-serif;
      font-size: 15pt;
      font-weight: bold;
      color: #1c3a5e;
      letter-spacing: 0.4pt;
      text-transform: uppercase;
      margin: 1mm 0 1mm 0;
  }
  .empresa-subtitulo {
      font-family: Arial, Helvetica, "DejaVu Sans", sans-serif;
      font-size: 8.5pt;
      color: #555555;
      margin: 0;
  }
  .numero-factura {
      font-family: Arial, Helvetica, "DejaVu Sans", sans-serif;
      font-size: 12pt;
      font-weight: bold;
      color: #1c3a5e;
      text-align: right;
      margin: 1mm 0 1mm 0;
  }
  .data-factura {
      font-family: Arial, Helvetica, "DejaVu Sans", sans-serif;
      font-size: 8.5pt;
      color: #555555;
      text-align: right;
      margin: 0;
  }

  .linha-grossa { border-top: 1.6pt solid #1c3a5e; margin-top: 2mm; }
  .linha-fina   { border-top: 0.5pt solid #1c3a5e; margin-top: 0.7mm; margin-bottom: 4mm; }

  /* ---------- Título ---------- */
  .titulo-bloco { text-align: center; margin-bottom: 6mm; }
  .titulo-bloco h1 {
      font-family: Arial, Helvetica, "DejaVu Sans", sans-serif;
      font-size: 18pt;
      letter-spacing: 2pt;
      color: #1c3a5e;
      text-transform: uppercase;
      margin: 0 0 2mm 0;
      font-weight: bold;
  }
  .titulo-sublinha {
      width: 38mm;
      margin: 0 auto;
      border-bottom: 1.4pt solid #1c3a5e;
  }
  .estado {
      font-family: Arial, Helvetica, "DejaVu Sans", sans-serif;
      font-size: 8.5pt;
      letter-spacing: 0.8pt;
      text-transform: uppercase;
      color: #6b7280;
      margin: 2mm 0 0 0;
  }
  .anulada {
      font-family: Arial, Helvetica, "DejaVu Sans", sans-serif;
      font-size: 8.5pt;
      font-weight: bold;
      letter-spacing: 1pt;
      text-transform: uppercase;
      color: #b3413a;
      border: 1pt solid #b3413a;
      padding: 1.5mm 3mm;
      width: 80mm;
      margin: 3mm auto 0 auto;
  }

  /* ---------- Títulos de secção ---------- */
  .secao-titulo {
      font-family: Arial, Helvetica, "DejaVu Sans", sans-serif;
      font-size: 9.5pt;
      font-weight: bold;
      letter-spacing: 1pt;
      text-transform: uppercase;
      color: #1c3a5e;
      border-bottom: 0.75pt solid #c7cdd4;
      padding-bottom: 1.2mm;
      margin: 5mm 0 2.5mm 0;
  }

  /* ---------- Campos de dados (rótulo + valor) ---------- */
  table.campos {
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed;
      margin-bottom: 1mm;
      page-break-inside: avoid;
  }
  table.campos td { padding: 1.3mm 4mm 2.5mm 0; vertical-align: bottom; }

  .campo-rotulo {
      display: block;
      font-family: Arial, Helvetica, "DejaVu Sans", sans-serif;
      font-size: 7.3pt;
      color: #6b7280;
      text-transform: uppercase;
      letter-spacing: 0.5pt;
      margin-bottom: 1mm;
  }
  .campo-valor {
      display: block;
      font-size: 10.3pt;
      font-weight: bold;
      color: #111111;
      border-bottom: 0.75pt solid #9aa3ad;
      padding-bottom: 1mm;
      min-height: 4.5mm;
  }

  /* ---------- Tabela de itens ---------- */
  table.tabela-itens {
      width: 100%;
      border-collapse: collapse;
      margin: 2mm 0 4mm 0;
      font-size: 9.5pt;
  }
  table.tabela-itens th {
      background: #eef1f4;
      color: #1c3a5e;
      font-family: Arial, Helvetica, "DejaVu Sans", sans-serif;
      font-size: 7.6pt;
      text-transform: uppercase;
      letter-spacing: 0.3pt;
      font-weight: bold;
      text-align: left;
      padding: 1.8mm 2mm;
      border: 0.75pt solid #c7cdd4;
  }
  table.tabela-itens td {
      padding: 1.6mm 2mm;
      border: 0.75pt solid #c7cdd4;
      vertical-align: top;
  }
  table.tabela-itens tr { page-break-inside: avoid; }
  .direita { text-align: right; }
  .centro  { text-align: center; }

  /* ---------- Totais ---------- */
  table.totais-wrapper {
      width: 100%;
      border-collapse: collapse;
      margin-top: 2mm;
      page-break-inside: avoid;
  }
  table.totais-wrapper td { vertical-align: top; padding: 0; }
  td.totais-esquerda { width: 50%; }
  td.totais-direita  { width: 50%; }

  table.totais {
      width: 100%;
      border-collapse: collapse;
      font-size: 9.8pt;
  }
  table.totais td {
      padding: 1.5mm 2.5mm;
      border-bottom: 0.5pt solid #c7cdd4;
  }
  table.totais td.direita { text-align: right; font-weight: bold; }
  table.totais tr.total-destaque td {
      background: #1c3a5e;
      color: #ffffff;
      font-weight: bold;
      font-size: 10.8pt;
      border-bottom: none;
  }
  table.totais tr.total-destaque td.direita { color: #ffffff; }

  /* ---------- Anotações ---------- */
  .nota-intro {
      font-style: italic;
      font-size: 10pt;
      line-height: 1.6;
      color: #333333;
      border-left: 2pt solid #1c3a5e;
      padding: 1mm 0 1mm 4mm;
      margin: 0 0 4mm 0;
      page-break-inside: avoid;
  }

  /* ---------- Assinatura ---------- */
  table.assinaturas {
      width: 100%;
      border-collapse: collapse;
      margin-top: 8mm;
      page-break-inside: avoid;
  }
  table.assinaturas td { vertical-align: top; width: 50%; text-align: center; padding: 0 4mm; }

  .carimbo-caixa {
      width: 40mm;
      margin: 0 auto 2mm auto;
      border: 1px dashed #9aa3ad;
      text-align: center;
      font-family: Arial, Helvetica, "DejaVu Sans", sans-serif;
      font-size: 7.3pt;
      color: #6b7280;
      text-transform: uppercase;
      letter-spacing: 0.3pt;
      line-height: 1.4;
      padding: 8mm 2mm;
  }

  .assinatura-linha {
      border-bottom: 0.75pt solid #1a1a1a;
      width: 75%;
      margin: 12mm auto 2mm auto;
  }
  .assinatura-cargo {
      font-family: Arial, Helvetica, "DejaVu Sans", sans-serif;
      font-style: italic;
      font-size: 8.5pt;
      color: #555555;
      margin: 0;
  }

  /* ---------- Rodapé ---------- */
  .rodape {
      margin-top: 8mm;
      padding-top: 2.5mm;
      border-top: 0.75pt solid #c7cdd4;
      text-align: center;
      font-family: Arial, Helvetica, "DejaVu Sans", sans-serif;
      font-size: 7.3pt;
      color: #8a8f97;
      line-height: 1.6;
  }

</style>
</head>
<body>

  <!-- Cabeçalho -->
  <table class="cabecalho">
    <tr>
      <td style="width:60%;">
        <p class="empresa-nome">{{ config('app.name') }}</p>
        <p class="empresa-subtitulo">Factura de venda</p>
      </td>
      <td style="width:40%;">
        <p class="numero-factura">Factura N.º {{ $numero }}</p>
        <p class="data-factura">Emitida em {{ $emitidaEm->format('d/m/Y H:i') }}</p>
      </td>
    </tr>
  </table>

  <div class="linha-grossa"></div>
  <div class="linha-fina"></div>

  <!-- Título -->
  <div class="titulo-bloco">
    <h1>Factura</h1>
    <div class="titulo-sublinha"></div>
    <p class="estado">Estado do pagamento: {{ $estadoPagamento }}</p>
    @if($anulada)
      <p class="anulada">Anulada em {{ $anuladaEm->format('d/m/Y H:i') }}</p>
    @endif
  </div>

  <!-- Dados da venda -->
  <div class="secao-titulo">Dados da Venda</div>
  <table class="campos">
    <colgroup><col style="width:34%"><col style="width:33%"><col style="width:33%"></colgroup>
    <tr>
      <td>
        <span class="campo-rotulo">Número da factura</span>
        <span class="campo-valor">{{ $numero }}</span>
      </td>
      <td>
        <span class="campo-rotulo">Data de emissão</span>
        <span class="campo-valor">{{ $emitidaEm->format('d/m/Y') }}</span>
      </td>
      <td>
        <span class="campo-rotulo">Número de itens</span>
        <span class="campo-valor">{{ $totalItens }}</span>
      </td>
    </tr>
    <tr>
      <td>
        <span class="campo-rotulo">Estado do pagamento</span>
        <span class="campo-valor">{{ $estadoPagamento }}</span>
      </td>
      <td colspan="2">
        <span class="campo-rotulo">Registado por (ID do utilizador)</span>
        <span class="campo-valor">{{ $sale->user_id }}</span>
      </td>
    </tr>
  </table>

  <!-- Itens da venda -->
  <div class="secao-titulo">Itens da Venda</div>
  <table class="tabela-itens">
    <thead>
      <tr>
        <th style="width:6%;" class="centro">Nº</th>
        <th style="width:10%;" class="centro">Ref.</th>
        <th>Produto</th>
        <th style="width:9%;" class="direita">Qtd.</th>
        <th style="width:17%;" class="direita">Preço Unit. (Kz)</th>
        <th style="width:18%;" class="direita">Subtotal (Kz)</th>
      </tr>
    </thead>
    <tbody>
      @forelse($sale->saleItems as $index => $item)
      <tr>
        <td class="centro">{{ $index + 1 }}</td>
        <td class="centro">{{ $item->product_id }}</td>
        <td>{{ $item->product_name }}</td>
        <td class="direita">{{ $item->qty }}</td>
        <td class="direita">{{ $kz($item->product_price) }}</td>
        <td class="direita">{{ $kz($item->subtotal) }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="6" class="centro">Sem itens nesta factura.</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <!-- Totais -->
  <table class="totais-wrapper">
    <tr>
      <td class="totais-esquerda"></td>
      <td class="totais-direita">
        <table class="totais">
          <tr>
            <td>Subtotal dos itens</td>
            <td class="direita">{{ $kz($subtotal) }}</td>
          </tr>
          <tr class="total-destaque">
            <td>Total da factura (Kz)</td>
            <td class="direita">{{ $kz($total) }}</td>
          </tr>
          <tr>
            <td>Total pago (Kz)</td>
            <td class="direita">{{ $kz($totalPago) }}</td>
          </tr>
          <tr>
            <td>Saldo em dívida (Kz)</td>
            <td class="direita">{{ $kz($saldo) }}</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

  <!-- Anotações -->
  @if(!empty($sale->note))
  <div class="secao-titulo">Anotações</div>
  <p class="nota-intro">{{ $sale->note }}</p>
  @endif

  <!-- Assinatura -->
  <table class="assinaturas">
    <tr>
      <td>
        <div class="carimbo-caixa">CARIMBO<br>DA EMPRESA</div>
      </td>
      <td>
        <div class="assinatura-linha"></div>
        <p class="assinatura-cargo">Responsável pela emissão</p>
      </td>
    </tr>
  </table>

  <!-- Rodapé -->
  <div class="rodape">
    {{ config('app.name') }} &nbsp;·&nbsp; Documento processado por computador<br>
    Processado em {{ now()->format('d/m/Y H:i') }}
  </div>

</body>
</html>
