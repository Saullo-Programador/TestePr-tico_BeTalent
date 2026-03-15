<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionProducts extends Model
{

    protected $fillable=[

        "transaction_id",
        "product_id",
        "quantity"

    ];

}
