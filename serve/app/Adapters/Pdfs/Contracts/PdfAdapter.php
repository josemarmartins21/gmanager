<?php

namespace App\Adapters\Pdfs\Contracts;


interface PdfAdapter
{
    /**
     * @throws \Exception
     */
    public function getPdf();

    /**
     * @throws \Exception
     */
    public function download();

    /**
    * @return void 
    * @throws \Exception
    */
    public function generate(): void;
}