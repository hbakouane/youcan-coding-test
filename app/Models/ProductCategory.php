<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    
    /**
     * table
     *
     * @var string
     */
    public $table = "product_category";
    
    /**
     * The fillable fields of the Product model
     *
     * @var array
     */
    public $fillable = ['product_id', 'category_id'];
}
