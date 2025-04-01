<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\Corporation;
use Illuminate\Http\Request;
use App\Http\Requests\StoreQuickProductRequest;

class DashboardController extends Controller
{
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
        dd('YAY');
    }
}
