<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipeStepRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'description' => ['required', 'string'],
            'cookTime' => ['required', 'string'],
            'prepTime' => ['required', 'string'],
            'recipeId' => ['required'],
            'ingredients' => ['nullable', 'array'],
            'ingredients.*.name' => ['required', 'string'],

        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'cook_time' => $this->cookTime,
            'prep_time' => $this->prepTime,
            'recipe_id' => $this->recipeId

        ]);
    }
}
