<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIngredientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // TODO: Change this with auth system
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'unique:ingredients'],
            'ingredientCategoryId' => ['nullable', 'exists:ingredient_categories,id'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'ingredient_category_id' => $this->ingredientCategoryId,
        ]);
    }
}
