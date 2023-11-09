<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGroupItem extends Model
{
    use HasFactory;

    protected $table = 'product_group_items';

    public $timestamps = false;

    protected $fillable = [
        'group_id',
        'product_id'
    ];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
