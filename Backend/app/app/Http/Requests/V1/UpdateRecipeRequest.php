<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $method = $this->method();
        if ($method == 'PUT') {
            return true; // TODO: Change this
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        $method = $this->method();
        if ($method == 'PUT') {
            return [
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string'],
                'number_people' => ['required', 'integer'],
                'image_url' => ['nullable', 'string', 'url'],
                'rating' => ['required', 'integer', 'min:1', 'max:5'],
                'recipe_steps' => ['required', 'array'],
                'recipe_steps.*.description' => ['required', 'string'],
                'recipe_steps.*.cook_time' => ['required', 'string'],
                'recipe_steps.*.prep_time' => ['required', 'string'],
                'recipe_steps.*.ingredients' => ['nullable', 'array'],
                'recipe_steps.*.ingredients.*.name' => ['nullable', 'string'],
                'recipe_steps.*.ingredients.*.measurement' => ['nullable', 'string'],
                'recipe_steps.*.ingredients.*.quantity' => ['required', 'numeric'],
                'recipe_steps.*.utensils' => ['nullable', 'array'],
                'recipe_steps.*.utensils.*.name' => ['nullable', 'string'],
            ];
        }
        // else {
        //     // Method is PATCH
        //     return [
        //         'title' => ['sometimes', 'required', 'string', 'max:255'],
        //         'description' => ['sometimes', 'required', 'string'],
        //         'number_people' => ['sometimes', 'required', 'integer'],
        //         'image_url' => ['sometimes', 'nullable', 'string', 'url'],
        //         'rating' => ['sometimes', 'required', 'integer', 'min:1', 'max:5'],
        //         'recipe_steps' => ['sometimes', 'required', 'array'],
        //         'recipe_steps.*.description' => ['sometimes', 'required', 'string'],
        //         'recipe_steps.*.cook_time' => ['sometimes', 'required', 'string'],
        //         'recipe_steps.*.prep_time' => ['sometimes', 'required', 'string'],
        //         'recipe_steps.*.ingredients' => ['sometimes', 'nullable', 'array'],
        //         'recipe_steps.*.ingredients.*.name' => ['sometimes', 'nullable', 'string'],
        //         'recipe_steps.*.ingredients.*.measurement' => ['sometimes', 'nullable', 'string'],
        //         'recipe_steps.*.ingredients.*.quantity' => ['required', 'numeric'],
        //         'recipe_steps.*.utensils' => ['sometimes', 'nullable', 'array'],
        //         'recipe_steps.*.utensils.*.name' => ['sometimes', 'nullable', 'string'],
        //     ];
        // }
    }

    // Convert camelCase to camel_case format
    protected function prepareForValidation()
    {
        if ($this->numberPeople)
            $this->merge([
                'number_people' => $this->numberPeople,
            ]);
    }
}
