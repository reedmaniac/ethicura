<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CorporationProductResource;
use App\Http\Resources\Api\CorporationResource;
use App\Models\Corporation;
use App\Models\Product;
use Illuminate\Http\Request;

class CorporationsController extends Controller
{
    /**
     * List corporations with optional keyword search.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Corporation::with('ethicalLabels');

        if ($request->has('keyword')) {
            $query->where('name', 'LIKE', '%' . $request->keyword . '%');
        }

        return CorporationResource::collection($query->paginate(10));
    }

    /**
     * Show a single corporation.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Corporation $corporation)
    {
        return response()->json(new CorporationResource($corporation));
    }

    /**
     * List products with optional keyword search.
     *
     * @param Corporation $corporation the corporation to which the products should belong
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexProducts(Request $request, Corporation $corporation)
    {
        $query = $corporation->products()->with('certifications', 'packaging');

        if ($request->has('keyword')) {
            $query->where('name', 'LIKE', '%' . $request->keyword . '%');
        }

        return CorporationProductResource::collection($query->paginate(10));
    }

    /**
     * Show a single product.
     *
     * @param Corporation $corporation the corporation to which the product should belong
     * @param Product     $product     the product being retrieved
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showProduct(Corporation $corporation, Product $product)
    {
        if ($product->corporation_id !== $corporation->id) {
            return response()->json(['error' => 'Product does not belong to this corporation.'], 404);
        }

        return response()->json(new CorporationProductResource($product));
    }
}
