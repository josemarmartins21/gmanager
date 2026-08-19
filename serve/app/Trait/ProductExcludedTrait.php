<?php

namespace App\Trait;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Database\Eloquent\Collection ;

trait ProductExcludedTrait
{
    /**
     * @return Collection
    * @throws \Exception
    */
    public function allTrashed(): Collection 
    {
        try {
            
            return Product::onlyTrashed()->latest()->get();

        } catch (\Throwable $th) {
            throw new \Exception(
               $th->getMessage() /* "Erro ao excluir o producto" */);
        }
    }

    /**
     * @param Product
     * 
     * @return void
     * @throws \Exception
     */

    public function restore(string $id): void 
    {
        try {

            $product = Product::onlyTrashed()->find($id);

            if ($product) {
                $product->restore();
                return;
            }

            throw new ModelNotFoundException("Este producto ainda não foi excluido ou já foi excluido permanentemente");
            

        } catch (ModelNotFoundException $th) {
            throw new \Exception(
               $th->getMessage() /* "Erro ao excluir o producto" */);
        }
        catch (\Throwable $th) {
            throw new \Exception(
               $th->getMessage() /* "Erro ao excluir o producto" */);
        }
    }

    /**
    * @return void
    * @throws \Exception
    */
    public function cleanAll(): void
    {
        try {
            
           Product::onlyTrashed()->forceDelete();

        } catch (\Throwable $th) {
            throw new \Exception(
               $th->getMessage() /* "Erro ao excluir todos os registos" */);
        }
    }
}
