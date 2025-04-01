<?php

namespace App\Http\Controllers\Dashboard;

use App\Services\ProductsService;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\Corporation;
use Illuminate\Http\Request;
use App\Http\Requests\StoreQuickProductRequest;

class DashboardController extends Controller
{
    /**
     * The ProductsService
     *
     * @var ProductsService
     */
    protected $products_service;

    /**
     * Constructor
     *
     * @param ProductsService $products_service
     * @return void
     */
    public function __construct(ProductsService $products_service)
    {
        $this->products_service = $products_service;
    }

    /**
     * Show Main Dashboard
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        return Inertia::render(
            'dashboard/Dashboard',
            [
                'corporations' => Corporation::select('name', 'id')->orderBy('name')->get(),
            ]
        );
    }


    /**
     * Store Quick Product Create
     *
     * @return \Inertia\Response
     */
    public function storeQuickProduct(StoreQuickProductRequest $request)
    {
        $product = $this->products_service->create($request->all());

        return redirect(
            route(
                'products.edit',
                [
                    'product' => $product,
                ]
            )
        );
    }
}
