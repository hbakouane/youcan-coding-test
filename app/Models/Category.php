<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    /**
     * The fillables of the Category model
     *
     * @var array
     */
    public $fillable = ['name', 'parent'];

    public static $rules = [
        'name' => 'required',
        'parent' => 'required'
    ];
    
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
     * Children relation
     *
     * @return void
     */
    public function children()
    {
        return $this->hasMany( 'App\Models\Category', 'parent', 'id' );
    }
        
    /**
     * Parent relation
     *
     * @return void
     */
    public function parent()
    {
        return $this->hasOne( 'App\Models\Category', 'id', 'parent' );
    }
    
    /**
     * Products relation
     *
     * @return void
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
