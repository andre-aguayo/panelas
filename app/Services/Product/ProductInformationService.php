<?php

namespace App\Services\Product;

use App\Models\Product;
use Exception;
use App\Models\ProductInformation;
use Illuminate\Support\Facades\DB;
use App\Services\Product\Interfaces\ProductInformationServiceInterface;
use FFI;

class ProductInformationService implements ProductInformationServiceInterface
{

    public function storeInformations(array $productInformations, string $productId): array
    {

        $productInformationResponse = [];
        foreach ($productInformations as $productInformation) {
            $productInformationResponse[] = ProductInformation::create([
                'product_id' => $productId,
                'name' => $productInformation['name'],
                'description' => $productInformation['description'],
            ]);
        }

        return $productInformationResponse;
    }

    public function updateInformations(array $productInformations): array
    {
        $informationResponse = [];
        foreach ($productInformations as $productInformation) {
            $information = ProductInformation::where(
                ['id' => $productInformation['id']]
            )->first();

            if (!$information->update($productInformation))
                throw new Exception(__('requestError.product.productInformation.update'));

            $informationResponse[] = $information;
        }

        return $informationResponse;
    }

    /**
     * Delete informations in database
     * 
     * @throws Exception if dont delete
     * 
     * @param array $productInformations to update
     * @return void
     */
    private function destroyInformations(array $productInformations): void
    {
        foreach ($productInformations as $productInformation) {
            if (!ProductInformation::where(['id' => $productInformation['id']])->delete())
                throw new Exception('requestError.product.productInformation.delete');
        }
    }

    public function processInformationsRequest(array $productInformations, Product $product): array
    {
        $previousArrayInformations  = $product->productInformations->toArray();

        //store the new intormation     
        $productsStored = $this->informationToStore($productInformations,  $product->id);

        //remove informations deleted
        $this->informationToDelete($productInformations, $previousArrayInformations);

        //return informations to update
        return [
            ...$this->informationToUpdate($productInformations, $previousArrayInformations),
            ...$productsStored
        ];
    }

    /**
     * Give new product informations to store
     */
    private function informationToStore(array $a, string $productId): array
    {
        return $this->storeInformations(array_filter($a, function ($element) {
            return !isset($element['id']);
        }), $productId);
    }

    /**
     * Compare array diff to delete
     */
    private function informationToDelete(array $a, array $b)
    {
        return $this->destroyInformations(array_filter($b, function ($element) use ($a) {
            return isset($element['id']) && !in_array($element['id'], array_column($a, 'id'));
        }));
    }

    /**
     * Compare array to update informations
     */
    private function informationToUpdate(array $a, array $b): array
    {
        return $this->updateInformations(array_filter($a, function ($element) use ($b) {
            return isset($element['id']) && !in_array($element['id'], $b);
        }));
    }
}
