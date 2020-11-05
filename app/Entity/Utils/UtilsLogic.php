<?php
namespace App\Entity\Utils;
use App\Entity\Sales\SalesLogic;
use App\Entity\Product\ProductLogic;

class UtilsLogic
{
    public function getProductList()
    {
        $be = new ProductLogic();
        $list = $be->getProductList();
        return $list;
    }
}