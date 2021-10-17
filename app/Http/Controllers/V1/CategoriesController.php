<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CategoriesController extends Controller
{    
    /**
     * Categories index page
     *
     * @return void
     */
    public function index()
    {
        return view('categories.index');
    }
}
