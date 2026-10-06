<?php

namespace App\Strategies;

use App\Models\Product;
use App\Strategies\Contracts\PdfRepository;

class ProductPdfRepository implements PdfRepository
{
    public function all()
    {
        try {
                        
            return Product::select('*')
            ->orderBy('name')->get();

        } catch (\Throwable) {
            throw new \Exception("Erro ao gerar o PDF");
            
        }
    }
}