<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $fillable = ['name', 'parent'];

    public static $rules = [
        'name' => 'required',
        'parent' => 'required'
    ];

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

    public function children()
    {
        return $this->hasMany( 'App\Models\Category', 'parent', 'id' );
    }
    
    public function parent()
    {
        return $this->hasOne( 'App\Models\Category', 'id', 'parent' );
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
