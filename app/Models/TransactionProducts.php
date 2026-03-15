<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionProducts extends Model
{
    public $timestamps = false;
    protected $fillable=[

        "transaction_id",
        "product_id",
        "quantity"

    ];

}
