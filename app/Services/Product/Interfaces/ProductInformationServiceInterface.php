<?php

namespace App\Services\Product\Interfaces;

use App\Models\Product;
use App\Models\ProductInformation;

interface ProductInformationServiceInterface
{
    /**
     * @param array of products $productinformation
     * @param string $productId
     * @return array of product informations
     */
    public function storeInformations(array $productinformation, string $productId): array;

    /**
     * Remove previously uninformed information and add new information (no "product_information_id")
     *  
     * @throws Exception if don't update information
     * 
     * @param array of products informations
     * @return array of product information updated
     */
    public function updateInformations(array $productInformations): array;

    /**
     * Processes product information to remove, store and update from request
     * 
     * @throws Exception case don't delete or don't store
     * 
     * @param array $productInformations 
     * @param Product $product to compare
     * @return array product informations processed
     */
    public function processInformationsRequest(array $productInformations, Product $product): array;
}
