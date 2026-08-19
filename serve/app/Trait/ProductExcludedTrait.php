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

            $product = Product::onlyTrashed()->findOrFail($id);

            $product->restore();

        } catch (ModelNotFoundException) {
            throw new \Exception(
               "Este producto não se encontra na lixeira" /* "Erro ao excluir o producto" */);
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
    public function permanentlyDelete(string $id): void
    {
        try {

            $product = Product::onlyTrashed()->findOrFail($id);

            $product->forceDelete();
            
        } catch (ModelNotFoundException) {
            throw new \Exception("Este producto não se encontra na lixeira");
            
        } catch (\Throwable) {
            throw new \Exception("Erro ao excluir definitivamente o producto");
            
        }
    }

    /**
    * @return void
    * @throws \Exception
    */
    public function cleanAll(): void
    {
        try {

            $nbExcluded = Product::onlyTrashed()->count();

            if ($nbExcluded > 0) {
                Product::onlyTrashed()->forceDelete();
                return;
            } 

            throw new \Exception("A lixeira já se encontra vazia!"); 


        } catch (\Throwable $th) {
            throw new \Exception(
               $th->getMessage() /* "Erro ao excluir todos os registos" */);
        }
    }
}
