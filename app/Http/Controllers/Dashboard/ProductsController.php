<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\Product;
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
        return Inertia::render(
            'products/Products',
            [
                'products' => Product::with('corporation')
                    ->select('id', 'uuid', 'name', 'description', 'corporation_id', 'created_at', 'status')
                    ->get(),
            ]
        );
    }
}
