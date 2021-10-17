<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'description' => 'required',
        'price' => 'required|float',
        'image' => 'required'
    ];
    
    /**
     * The fillables of the Product model
     *
     * @var array
     */
    public $fillable = ['name', 'description', 'price', 'image', 'category_id'];
    
    /**
     * Get the required fields of the Product model
     *
     * @return void
     */
    public static function getRequiredFields()
    {
        $requiredFields = [];
        foreach(self::$rules as $key => $value) {
            if (str_contains($value, 'required')) {
                array_push($requiredFields, $key);
            }
        }
        return $requiredFields;
    }
    
    /**
     * Categories relation
     *
     * @return void
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
