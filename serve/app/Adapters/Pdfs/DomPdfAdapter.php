<?php

namespace App\Adapters\Pdfs;

use App\Adapters\Pdfs\Contracts\PdfAdapter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class DomPdfAdapter implements PdfAdapter
{
    private object $pdf;

    public function __construct(
        private string $pdfType,
        private $content = [],
    ) {
        try {

            $this->pdf = Pdf::loadView($this->pdfType, ['data' => $this->content])
            ->setPaper('a4', 'portrait');

        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage());
        }

    }

    public function download()
    {
        try {

            return $this->getPdf()
            ->download(
                now()->format('Y-m-d_H-i-s') 
                . '-' . Str::uuid() . '.pdf'
            );

        } catch (\Throwable) {
            throw new \Exception("Erro ao baixar o PDF");
        }
    }

    public function generate(): void
    {
        try {

            $content = $this->getPdf()->output();

            $filename = Str::uuid() . now()->getTimestamp() . '.pdf';
            $saved = Storage::disk('reports')->put($filename, $content);

            if ($saved === false) {
                throw new \RuntimeException('Não foi possível salvar o arquivo');
            }

        } catch (\RuntimeException $e) {
            throw new \Exception($e->getMessage());
        } catch (\Throwable) {
            throw new \Exception("Erro ao processar o PDF");
        }
    }

    public function getPdf()
    {
        if (! $this->pdf) {
            throw new \Exception("Erro ao processar o PDF");
        }

        return $this->pdf;
    }
}