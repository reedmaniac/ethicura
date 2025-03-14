<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'barcode' => 'sometimes|required|string|unique:products,barcode,' . $this->route('product')->id . '|max:255',
            'corporation_id' => 'sometimes|required|exists:corporations,id',
            'status' => 'sometimes|required|in:draft,published',

            'saturated_fat' => 'nullable|numeric|min:0',
            'trans_fat' => 'nullable|numeric|min:0',
            'cholesterol' => 'nullable|integer|min:0',
            'dietary_fiber' => 'nullable|numeric|min:0',
            'sugars' => 'nullable|numeric|min:0',
            'added_sugars' => 'nullable|numeric|min:0',
            'sodium' => 'nullable|integer|min:0',
            'vitamin_a' => 'nullable|integer|min:0',
            'vitamin_c' => 'nullable|integer|min:0',
            'vitamin_d' => 'nullable|integer|min:0',
            'calcium' => 'nullable|integer|min:0',
            'iron' => 'nullable|integer|min:0',
            'potassium' => 'nullable|integer|min:0',
            'net_carbs' => 'nullable|numeric|min:0',
            'glycemic_index' => 'nullable|in:low,medium,high',
            'serving_size' => 'nullable|string|max:255',
            'servings_per_container' => 'nullable|integer|min:1',
            'calories' => 'nullable|numeric|min:0',
            'protein' => 'nullable|numeric|min:0',
        ];
    }
}
