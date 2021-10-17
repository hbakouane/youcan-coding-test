<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductsController extends Controller
{    
    /**
     * Products index page
     *
     * @return void
     */
    public function index()
    {
        return view('products.index');
    }
}
