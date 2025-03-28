<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Show Main Dashboard
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('products/Products');
    }
}
