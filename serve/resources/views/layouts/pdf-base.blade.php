@use('Carbon\Carbon')
<!DOCTYPE html>
<!--
  Recibo de Salário — modelo institucional
  HTML + CSS puro, sem Blade/PHP/JavaScript, preparado para DOMPDF (A4, 20mm).
  Mesma direção de arte dos documentos anteriores.
  Documento de processamento salarial mensal: vencimentos e descontos
  lado a lado (layout clássico de recibo de vencimento), seguidos do
  valor líquido a receber. Segurança Social (INSS) e Imposto sobre o
  Rendimento do Trabalho (IRT) surgem como descontos-tipo, com o valor
  a preencher pela instituição de acordo com as taxas em vigor.
  Convenção: todo o texto em MAIÚSCULAS é um placeholder visual a substituir
  por variáveis Blade/PHP numa etapa posterior. As linhas de vencimentos e
  descontos devem repetir-se com .
-->
<html lang="pt-AO">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title')</title>
<style>

  /* ---------- Configuração da página (A4 / impressão / DOMPDF) ---------- */
  @page {
      size: A4 portrait;
      margin: 20mm;
  }

  * { box-sizing: border-box; }

  html, body {
      margin: 0;
      padding: 0;
      background: #ffffff;
      color: #1a1a1a;
      font-family: "Times New Roman", Times, "DejaVu Serif", serif;
      font-size: 10.8pt;
      line-height: 1.5;
  }

  .documento {
      max-width: 210mm;
      margin: 0 auto;
      padding: 10mm 6mm;
  }

  /* ---------- Cabeçalho institucional ---------- */
  table.cabecalho {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 3mm;
      page-break-inside: avoid;
  }
  table.cabecalho td { vertical-align: top; padding-right: 0px; }

  .logo-caixa {
      width: 26mm;
      border: 1px dashed #9aa3ad;
      text-align: center;
      font-family: Arial, Helvetica, "DejaVu Sans", sans-serif;
      font-size: 7pt;
      color: #6b7280;
      text-transform: uppercase;
      letter-spacing: 0.3pt;
      line-height: 1.4;
      padding: 8mm 1.5mm;
  }

  .instituicao-info { padding-left: 6mm; font-family: Arial, Helvetica, "DejaVu Sans", sans-serif; }
  .instituicao-nome {
      font-size: 15pt;
      font-weight: bold;
      color: #1c3a5e;
      letter-spacing: 0.4pt;
      text-transform: uppercase;
      margin: 1mm 0 2mm 0;
  }
  .instituicao-contacto {
      font-size: 8.3pt;
      color: #555555;
      margin: 0;
      line-height: 1.6;
  }

  .linha-grossa { border-top: 1.6pt solid #1c3a5e; margin-top: 2mm; }
  .linha-fina   { border-top: 0.5pt solid #1c3a5e; margin-top: 0.7mm; margin-bottom: 4mm; }

  .numero-declaracao {
      text-align: right;
      font-family: Arial, Helvetica, "DejaVu Sans", sans-serif;
      font-size: 9pt;
      color: #555555;
      font-style: italic;
      margin-bottom: 6mm;
  }

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
  .subtitulo {
      font-family: Arial, Helvetica, "DejaVu Sans", sans-serif;
      font-size: 9pt;
      letter-spacing: 0.8pt;
      text-transform: uppercase;
      color: #6b7280;
      margin: 2mm 0 0 0;
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

  /* ---------- Campos de dados ---------- */
  table.campos {
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed;
      margin-bottom: 2mm;
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
      font-size: 10.5pt;
      font-weight: bold;
      color: #111111;
      border-bottom: 0.75pt solid #9aa3ad;
      padding-bottom: 1mm;
      min-height: 4.5mm;
  }

  /* ---------- Tabelas de vencimentos / descontos / resumo ---------- */
  table.disciplinas {
      width: 100%;
      border-collapse: collapse;
      margin: 0 0 3mm 0;
      font-size: 9.6pt;
  }
  table.disciplinas th {
      background: #eef1f4;
      color: #1c3a5e;
      font-family: Arial, Helvetica, "DejaVu Sans", sans-serif;
      font-size: 8pt;
      text-transform: uppercase;
      letter-spacing: 0.4pt;
      font-weight: bold;
      text-align: left;
      padding: 1.8mm 2.5mm;
      border: 0.75pt solid #c7cdd4;
  }
  table.disciplinas td {
      padding: 1.6mm 2.5mm;
      border: 0.75pt solid #c7cdd4;
  }
  table.disciplinas th:last-child,
  table.disciplinas td:last-child { text-align: right; width: 34%; }
  table.disciplinas tr.linha-media td {
      font-weight: bold;
      background: #f7f8f9;
      border-top: 1.2pt solid #1c3a5e;
  }
  table.disciplinas tr.linha-extenso td {
      font-style: italic;
      font-size: 9pt;
      color: #333333;
      text-align: left;
      border-top: none;
  }

  .coluna-titulo {
      font-family: Arial, Helvetica, "DejaVu Sans", sans-serif;
      font-size: 8.5pt;
      font-weight: bold;
      letter-spacing: 0.4pt;
      text-transform: uppercase;
      color: #1c3a5e;
      margin: 0 0 1.5mm 0;
  }

  /* ---------- Emissão / assinaturas ---------- */
  .emissao-local {
      text-align: right;
      font-size: 10.3pt;
      margin: 6mm 0 8mm 0;
  }

  table.assinaturas {
      width: 100%;
      border-collapse: collapse;
      margin-top: 4mm;
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
  .assinatura-nome { font-weight: bold; font-size: 10pt; margin: 0; }
  .assinatura-cargo {
      font-family: Arial, Helvetica, "DejaVu Sans", sans-serif;
      font-style: italic;
      font-size: 8.7pt;
      color: #555555;
      margin: 0.8mm 0 0 0;
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

    /*   =========================================================
    CSS A ADICIONAR AO LAYOUT BASE (dentro da <style> partilhada)
    ========================================================= */

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

  /* ---------- Ajuste responsivo (ecrãs pequenos; não afecta o PDF A4) ---------- */
  @media screen and (max-width: 600px) {
      .documento { padding: 6mm 3mm; }
      table.cabecalho, table.cabecalho tbody, table.cabecalho tr, table.cabecalho td {
          display: block; width: 100% !important;
      }
      .instituicao-info { padding-left: 0; margin-top: 3mm; text-align: center; }
      .logo-caixa { margin: 0 auto; }
      table.campos, table.campos tbody, table.campos tr, table.campos td {
          display: block; width: 100% !important;
      }
      table.assinaturas, table.assinaturas tbody, table.assinaturas tr, table.assinaturas td {
          display: block; width: 100% !important; margin-bottom: 8mm;
      }
  }

</style>
</head>
<body>
     <!-- Cabeçalho institucional -->
  <table class="cabecalho">
    <tr>
      <td style="width:26mm;">
        <div class="logo-caixa">LOGOTIPO DA<br>INSTITUIÇÃO</div>
      </td>
      <td class="instituicao-info">
        <p class="instituicao-nome">hamburgueria G Wey Carter</p>
        <p class="instituicao-contacto">
          Angola, Luanda, Camama&nbsp;&nbsp;|&nbsp;&nbsp;Tel.: +244 927 773 901<br>
          Email: josemar21@outlook.pt&nbsp;&nbsp;|&nbsp;&nbsp;NIF: 
        </p>
      </td>
    </tr>
  </table>

  <div class="linha-grossa"></div>
  <div class="linha-fina"></div>
  <div class="numero-declaracao">@yield('details')</div>

  <!-- Título -->
  <div class="titulo-bloco">
    <h1>@yield('title')</h1>
    <div class="titulo-sublinha"></div>
    <p class="subtitulo">{{ Carbon::now()->format('F') }} &nbsp;·&nbsp; {{ date('Y') }}</p>
  </div>
    <div class="documento">
        @yield('content')
    </div>
</body>
</html>
