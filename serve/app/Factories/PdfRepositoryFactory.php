<?php

namespace App\Factories;



use App\Services\products\ProductService;
use App\Strategies\Contracts\PdfRepository;
use App\Strategies\ProductPdfRepository;
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
                'pdfs.products' => new ProductPdfRepository(new ProductService()),
            };

        } catch (UnhandledMatchError) {
            throw new \Exception("Tipo de recibo indisponível");
        } catch (\Throwable) {
            throw new \Exception("Erro ao processar o PDF");
        }
    }
}