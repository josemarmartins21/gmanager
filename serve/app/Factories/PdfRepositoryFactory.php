<?php

namespace App\Factories;

use App\Strategies\Pdfs\Contracts\PdfRepository;
use App\Strategies\Pdfs\ProductPdfRepository;
use App\Strategies\Pdfs\SalePdfRepository;
use App\Strategies\Pdfs\StockMovmentPdfRepository;
use UnhandledMatchError;

class PdfRepositoryFactory
{
    /**
     * @throws \Exception
     */
    public static function create(string $pdfType, ?string $id = null): PdfRepository
    {
        try {

            return match ($pdfType) {
                'pdfs.cantina-lista-produtos' => new ProductPdfRepository(),
                'pdfs.cantina-movimentacao-estoque' => new StockMovmentPdfRepository(),
                'pdfs.factura-sistema-gestao' => new SalePdfRepository($id),   
            };

        } catch (UnhandledMatchError) {
            throw new \Exception("Tipo de recibo indisponível");
        } catch (\Throwable) {
            throw new \Exception("Erro ao processar o PDF");
        }
    }
}