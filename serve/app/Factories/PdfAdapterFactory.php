<?php

namespace App\Factories;

use App\Adapters\Pdfs\Contracts\PdfAdapter;
use App\Adapters\Pdfs\DomPdfAdapter;
use UnhandledMatchError;

class PdfAdapterFactory 
{
    /**
     * @return PdfAdapter
     * @throws \Exception
     */
    public static function create(
        string $drive, 
        string $pdfType, 
        $content = [],
    ): PdfAdapter
    {
        try {

            return match ($drive) {
                'dompdf' => new DomPdfAdapter($pdfType, $content),
            };

        } catch (UnhandledMatchError) {
            throw new \Exception("Erro ao processar o PDF 1");
            
        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage());
        }
    }
}