<?php

namespace App\Strategies;

use App\Services\products\contracts\ProductInterface;
use App\Strategies\Contracts\PdfRepository;

class ProductPdfRepository implements PdfRepository
{
    public function __construct(
        private ProductInterface $productService,
    )
    {}

    public function all()
    {
        try {
            
            return $this->productService->all();

        } catch (\Throwable) {
            throw new \Exception("Erro ao gerar o PDF");
            
        }
    }
}