<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public static $rules = [
        'name' => 'required',
        'description' => 'required',
        'price' => 'required|float',
        'image' => 'required'
    ];

    public $fillable = ['name', 'description', 'price', 'image', 'category_id'];

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

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
