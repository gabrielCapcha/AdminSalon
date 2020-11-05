<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Series extends Model {
    protected $connection = 'mysql';
	const TABLE_NAME      = 'sal_series';
	const STATE_ACTIVE    = true;
	const STATE_INACTIVE  = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		//Table Rows
		'id', 'com_subsidiaries_id', 'serie', 'number',
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
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $table = self::TABLE_NAME;    
}
