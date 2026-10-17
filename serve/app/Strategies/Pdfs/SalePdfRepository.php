<?php

namespace App\Strategies\Pdfs;


use App\Models\Sale;
use App\Strategies\Pdfs\Contracts\PdfRepository;
use Illuminate\Support\Facades\Log;

class SalePdfRepository implements PdfRepository
{
    public function __construct(
        private string $id,
    )
    {}


    public function all()
    {
        try {
                        
            $sale =  Sale::with('saleItems')
            ->where('id', $this->id)
            ->firstOrFail();

            return $sale;

        } catch (\Throwable $e) {
            Log::error("Erro ao gerar PDF", [
                'message' =>$e->getMessage(),
            ]);

            throw new \Exception("Erro ao gerar o PDF");
            
        }
    }
}