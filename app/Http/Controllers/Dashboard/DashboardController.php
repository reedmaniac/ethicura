<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuickCorporationRequest;
use App\Http\Requests\StoreQuickProductRequest;
use App\Models\Corporation;
use App\Services\CorporationsService;
use App\Services\ProductsService;
use Illuminate\Http\RedirectResponse;
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
     * The Corporation Service
     *
     * @var CorporationsService
     */
    protected $corporations_service;

    /**
     * Constructor
     *
     * @param ProductsService $products_service
     * @return void
     */
    public function __construct(ProductsService $products_service, CorporationsService $corporations_service)
    {
        $this->products_service = $products_service;
        $this->corporations_service = $corporations_service;
    }

    /**
     * Show Main Dashboard
     *
     * @param Request $request
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
     * @param StoreQuickProductRequest $request
     * @return RedirectResponse
     */
    public function storeQuickProduct(StoreQuickProductRequest $request): RedirectResponse
    {
        $product = $this->products_service->create($request->all());

        return redirect(
            route(
                'dashboard.products.edit',
                [
                    'product' => $product,
                ]
            )
        );
    }

    /**
     * Store Quick Corporation Create
     *
     * @param StoreQuickCorporationRequest $request
     * @return RedirectResponse
     */
    public function storeQuickCorporation(StoreQuickCorporationRequest $request): RedirectResponse
    {
        $corporation = $this->corporations_service->create($request->all());

        return redirect(
            route(
                'dashboard.corporations.edit',
                [
                    'corporation' => $corporation,
                ]
            )
        );
    }
}
