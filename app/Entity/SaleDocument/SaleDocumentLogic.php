<?php
namespace App\Entity\SaleDocument;
use App\Models\SaleDocument;
use App\Models\TypePayment;
use App\Models\TypeDocument;
use App\Models\Series;
use App\Models\SaleDocumentDetail;
use App\Models\Product;
use Auth;
class SaleDocumentLogic
{
    #private functions
    #public functions
    public function getSaleDocumentList($params = [])
    {
        $list = SaleDocument::leftJoin(TypePayment::TABLE_NAME, TypePayment::TABLE_NAME.'.id', '=',
            SaleDocument::TABLE_NAME.'.sal_type_payment')
            ->leftJoin(TypeDocument::TABLE_NAME, TypeDocument::TABLE_NAME.'.id', '=',
                SaleDocument::TABLE_NAME.'.sal_type_document_id')
            ->select(SaleDocument::TABLE_NAME . '.*',
                TypePayment::TABLE_NAME . '.name as payment_name',
                TypeDocument::TABLE_NAME . '.name as type_document_name',
                TypeDocument::TABLE_NAME . '.code as type_document_code')
            ->with('items')
            ->whereNull(SaleDocument::TABLE_NAME . '.deleted_at')
            ->get();
        return $list;    
    }
    public function getSaleDocumentById($id)
    {
        $object = SaleDocument::find($id)
            ->whereNull(SaleDocument::TABLE_NAME . '.deleted_at')
            ->first();
        return $object;
    }
    public function createSaleDocument($params = [])
    {
        if (isset($params['sal_series'])) {
            $serie = Series::find($params['sal_series']);
            if (!is_null($serie)) {
                $params['serie'] = $serie->serie;
                $params['correlative'] = $serie->number;
                $params['ticket'] = $serie->serie . '-' . str_pad($serie->number, 8, '0', STR_PAD_LEFT);
                $serie->number = $serie->number + 1;
                $serie->save();
            }
        }
        $params['taxes'] = $params['amount'] * 0.18;
        $params['sub_total'] = $params['amount'] - $params['taxes'] - $params['discount'];
        $object = SaleDocument::create($params);
        if (isset($params['items'])) {
            foreach ($params['items'] as $key => $value) {
                $item = null;
                $value['sal_sale_documents_id'] = $object->id;
                $item = Product::find($value['war_products_id']);
                if (!is_null($item)) {
                    if ($value['quantity'] < $item->stock) {
                        $item->stock =  $item->stock - $value['quantity'];
                        $item->save();
                    }
                }
                SaleDocumentDetail::create($value);
            }
        }
        return $object;
    }
    /* public function updateSaleDocument($id, $params = [])
    {
        $object = SaleDocument::find($id);
        $object->fill($params);
        $object->save();
        return $object;
    } */
    public function deleteSaleDocument($id)
    {
        $object = SaleDocument::find($id);
        $object->flag_active = SaleDocument::STATE_INACTIVE;
        $object->deleted_at = date("Y-m-d H:i:s");
        $object->save();
        return $object;
    }
}