<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProductGroup extends Model
{
    use HasFactory;

    protected $table = 'user_product_groups';

    public $timestamps = false;

    protected $fillable = [
        'discount',
        'user_id'
    ];

    public function productGroupItem()
    {
        return $this->hasMany(ProductGroupItem::class, 'group_id', 'id');
    }
}
