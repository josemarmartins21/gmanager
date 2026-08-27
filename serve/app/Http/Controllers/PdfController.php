<?php

namespace App\Http\Controllers;

use App\Adapters\Pdfs\Contracts\PdfAdapter;
use App\Factories\PdfAdapterFactory;
use App\Factories\PdfRepositoryFactory;

class PdfController extends Controller
{
    private PdfAdapter $pdf;
    private string $pdfDrive = 'dompdf';

    public function download(string $pdfType)
    {
        try {

            $repository = PdfRepositoryFactory::create('pdfs.' . $pdfType);

            $this->pdf = PdfAdapterFactory::create(
                $this->pdfDrive, 
                'pdfs.' . $pdfType, 
                $repository->all(),
            );
            
            return $this->pdf->download();

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),

            ], 500);
        }
    }
}
