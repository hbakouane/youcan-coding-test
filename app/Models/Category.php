<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function children()
    {
        return $this->hasMany( 'App\Models\Category', 'parent', 'id' );
    }
    
    public function parent()
    {
        return $this->hasOne( 'App\Models\Category', 'id', 'parent' );
    }
}
