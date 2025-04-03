<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuickProductRequest;
use App\Models\Corporation;
use App\Services\ProductsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
