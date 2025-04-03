<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Corporation;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Inertia::share('product_save_button_option', auth()->user()->product_save_button_option);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        // @todo
        $product = new Product();

        return redirect($this->saveRedirect($request, $product))
            ->with(
                'message',
                'Product "' . $product->name . '" has been created'
            );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        Inertia::share('product_save_button_option', auth()->user()->product_save_button_option);

        return Inertia::render(
            'products/Edit',
            [
                'product' => $product->load('certifications', 'packaging'),
                'corporations' => Corporation::select('name', 'id')->orderBy('name')->get(),
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        // @todo

        return redirect($this->saveRedirect($request, $product))
            ->with(
                'message',
                'Product "' . $product->name . '" has been updated'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
    }

    /**
     * Handle the Saving of the Save Button Redirect Option and Return Redirect
     * - Abstracted for use with corporation via trait later
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Http\Response
     */
    private function saveRedirect(Request $request, Model $model)
    {
        $supported_models = ['product', 'corporation'];
        $options = ['listing', 'continue_editing', 'create_another'];
        $model_class = Str::lower((new \ReflectionClass($model))->getShortName());

        if (!in_array($model_class, $supported_models)) {
            throw new \Exception('Invalid model class for save redirect');
        }

        $column_name = $model_class . '_save_button_option';
        $option_value = ($request->has('save_button_option') && in_array($request->input('save_button_option'), $options))
            ? $request->input('save_button_option')
            : auth()->user()->$column_name;

        if ($option_value !== auth()->user()->$column_name) {
            auth()->user()->$column_name = $option_value;
            auth()->user()->save();
        }

        switch ($option_value) {
            case 'continue_editing':
                return route('dashboard.' . Str::plural($model_class) . '.edit', [$model_class => $model->id]);
                break;
            case 'create_another':
                return route('dashboard.' . Str::plural($model_class) . '.create');
                break;
        }

        // Default to listing
        // If 'redirect' is specified, it is usually back to a search results
        return $request->input('redirect') ?? route('dashboard.' . Str::plural($model_class) . '.index');
    }
}
