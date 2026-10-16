<?php

namespace App\Factories;

use App\Strategies\Pdfs\Contracts\PdfRepository;
use App\Strategies\Pdfs\ProductPdfRepository;
use App\Strategies\Pdfs\StockMovmentPdfRepository;
use UnhandledMatchError;

class PdfRepositoryFactory
{
    /**
     * @throws \Exception
     */
    public static function create(string $pdfType): PdfRepository
    {
        try {

            return match ($pdfType) {
                'pdfs.cantina-lista-produtos' => new ProductPdfRepository(),
                'pdfs.cantina-movimentacao-estoque' => new StockMovmentPdfRepository(),
            };

        } catch (UnhandledMatchError) {
            throw new \Exception("Tipo de recibo indisponível");
        } catch (\Throwable) {
            throw new \Exception("Erro ao processar o PDF");
        }
    }
}