<?php

namespace App\Strategies\Pdfs\Contracts;


use Illuminate\Database\Eloquent\Collection;

interface PdfRepository
{
    /**
     * @throws \Exception
     */
    public function all();

}