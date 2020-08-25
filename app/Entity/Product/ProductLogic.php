<?php
namespace App\Entity\Product;

use App\Models\Product;

class ProductLogic
{
    #private functions
    #public functions
    public function getProductList($params = [])
    {
        $list = Product::select(Product::TABLE_NAME . '.*')
        ->get();
        return $list;
    }
}