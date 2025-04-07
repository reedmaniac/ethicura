<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

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

            'barcode' =>
                'nullable',
            'string',
            'max:64',
            'regex:/^[a-zA-Z0-9\-]+$/',
            'unique:products,barcode,' . $this->route('product')->id,

            'corporation_id' => 'required|exists:corporations,id',
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
            'glycemic_index' => 'nullable|in:low,medium,high',
            'serving_size' => 'nullable|string|max:255',
            'servings_per_container' => 'nullable|integer|min:1',
            'calories' => 'nullable|numeric|min:0',
            'protein' => 'nullable|numeric|min:0',
            'fat' => 'nullable|numeric|min:0',
            'carbohydrates' => 'nullable|numeric|min:0',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return \Illuminate\Validation\Validator
     */
    public function withValidator(Validator $validator)
    {
        $validator->sometimes('barcode', 'required', function ($input) {
            return $input->status === 'published';
        });
    }
}
