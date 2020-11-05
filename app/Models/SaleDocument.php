<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDocument extends Model {
    protected $connection = 'mysql';
    
	const TABLE_NAME      = 'sal_sale_documents';
	const STATE_ACTIVE    = true;
	const STATE_INACTIVE  = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		//Table Rows
		'id', 'correlative', 'serie', 'amount',
		'data_client', 'sal_type_document_id', 'ticket',
		'taxes', 'sub_total', 'discount','sal_series',
		'sal_type_payment',
		//Audit
		'flag_active', 'updated_at', 'deleted_at','created_at'
	];

    // protected $guarded = ['created_at'];

	/**
	 * Casting of attributes
	 *
	 * @var array
	 */
	protected $casts = [
		'data_client' => 'array',
	];

	public function items()
	{
		return $this->hasMany('App\Models\SaleDocumentDetail', 'sal_sale_documents_id');
	}
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $table = self::TABLE_NAME;    
}
