<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Corporation;
use App\Models\Product;
use App\Services\ProductsService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\UrlGenerator;

class ProductsController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(): InertiaResponse
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
     *
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function create(Request $request): InertiaResponse
    {
        Inertia::share('product_save_button_option', auth()->user()->product_save_button_option);

        return Inertia::render(
            'products/Create',
            [
                'cloned_product' => ($request->has('clone_id'))
                    ? Product::findOrFail($request->input('clone_id'))->load('certifications', 'packaging')
                    : null,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductRequest $request
     * @return RedirectResponse
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $product = $this->products_service->create(
            $request->only(array_keys($request->rules()))
        );

        return redirect($this->saveRedirect($request, $product))
            ->with(
                'message',
                'Product "' . $product->name . '" has been created'
            );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Inertia\Response
     */
    public function edit(Product $product): InertiaResponse
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
     *
     * @param UpdateProductRequest
     * @param \App\Models\Product
     * @return RedirectResponse
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $product = $this->products_service->update(
            $product,
            $request->only(array_keys($request->rules())),
        );

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
     * @return \Illuminate\Routing\UrlGenerator
     */
    private function saveRedirect(Request $request, Model $model): UrlGenerator
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
