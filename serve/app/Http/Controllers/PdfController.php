<?php

namespace App\Http\Controllers;

use App\Adapters\Pdfs\Contracts\PdfAdapter;
use App\Factories\PdfAdapterFactory;
use App\Factories\PdfRepositoryFactory;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class PdfController extends Controller
{
    private PdfAdapter $pdf;
    private string $pdfDrive = 'dompdf';

    public function download(string $pdfType)
    {
        try {
            Gate::allowIf(fn(User $user) => $user->can('gerar PDFs'));
            
            $repository = PdfRepositoryFactory::create('pdfs.' . $pdfType);

            $this->pdf = PdfAdapterFactory::create(
                $this->pdfDrive, 
                'pdfs.' . $pdfType, 
                $repository->all(),
            );
            
            return $this->pdf->download();

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
