<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductImageUploadRequest;
use App\Jobs\ProcessProductImage;
use App\Models\ProductImage;
use Illuminate\Support\Str;

class ProductImageController extends Controller
{
    /**
     * Handle the product image upload.
     *
     * @param ProductImageUploadRequest $request   the validated request instance
     * @param int                       $productId the ID of the associated product
     *
     * @return \Illuminate\Http\JsonResponse the response containing upload status and data
     */
    public function upload(ProductImageUploadRequest $request, $productId)
    {
        $image = $request->file('image');
        $uuid = Str::uuid();
        $path = $image->storeAs('product_images/originals', "$uuid.{$image->getClientOriginalExtension()}", 'public');

        $productImage = ProductImage::create([
            'uuid' => $uuid,
            'product_id' => $productId,
            'type' => $request->type,
            'path' => $path,
        ]);

        ProcessProductImage::dispatch($productImage);

        return response()->json(['message' => 'Image uploaded successfully', 'data' => $productImage], 201);
    }
}
