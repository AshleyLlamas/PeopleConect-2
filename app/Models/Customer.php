<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'numberId',
        'name',
        'fraccionamiento',
        'manzana',
        'lote',
        'products_reference',
        'deals_reference',
        'email',
        'closing_date',
    ];
}
