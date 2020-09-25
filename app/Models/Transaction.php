<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;

    protected $table = 'transaction';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'amount', 'discount', 'additional_field', 'payment_type',
     'state', 'code','location_id','catatan_tambahan',
        'order_id', 'organization_id','payment_type_name', 'cash_amount', 
        'cash_charge','customer_origin', 'customer_destination'];
    
}
