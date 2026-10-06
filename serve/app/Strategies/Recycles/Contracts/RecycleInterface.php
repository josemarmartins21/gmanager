<?php

namespace App\Strategies\Recycles\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface RecycleInterface
{
    /**
     * @return LengthAwarePaginator
    * @throws \Exception
    */
    public function allTrashed(): LengthAwarePaginator;

    /**
     * @param Product
     * 
     * @return void
     * @throws \Exception
     */

    public function restore(string $id): void;

    public function restoreAll();

    /**
    * @return void
    * @throws \Exception
    */
    public function permanentlyDelete(string $id): void;

    /**
    * @return void
    * @throws \Exception
    */
    public function cleanAll(): void;

    /**
    * @return void
    * @throws \Exception
    */
    public function hasExcluded(): void;
}