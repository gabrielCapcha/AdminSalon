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
            ->whereNull(Product::TABLE_NAME . '.deleted_at')
            ->get();
        return $list;
    }
    public function getProductById($id)
    {
        $object = Product::find($id)
            ->whereNull(Product::TABLE_NAME . '.deleted_at')
            ->first();
        return $object;
    }
    public function createProduct($params = [])
    {
        $object = Product::create($params);
        return $object;
    }
    public function updateProduct($id, $params = [])
    {
        $object = Product::find($id);
        $object->fill($params);
        $object->save();
        return $object;
    }
    public function deleteProduct($id)
    {
        $object = Product::find($id);
        $object->flag_active = Product::STATE_INACTIVE;
        $object->deleted_at = date("Y-m-d H:i:s");
        $object->save();
        return $object;
    }
}