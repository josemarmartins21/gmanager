<?php

namespace App\Strategies\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface PdfRepository
{
    /**
     * @throws \Exception
     */
    public function all();

}