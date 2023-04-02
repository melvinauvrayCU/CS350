<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // TODO: Change this
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        // return [
        //     'title' => 'required|string',
        //     'description' => 'required|string',
        //     'numberPeople' => 'required|integer|min:1',
        //     'rating' => 'required|integer|min:1|max:5',
        //     '*.recipe_steps' => 'required|array|min:1',
        //     'imageUrl' => 'string',
        //     'userId' => ['required'],
        // ];

        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'number_people' => ['required', 'integer'],
            'image_url' => ['nullable', 'string', 'url'],
            'user_id' => ["required", 'exists:users,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'recipe_steps' => ['required', 'array'],
            'recipe_steps.*.description' => ['required', 'string'],
            'recipe_steps.*.cook_time' => ['required', 'string'],
            'recipe_steps.*.prep_time' => ['required', 'string'],
            'recipe_steps.*.ingredients' => ['nullable', 'array'],
            'recipe_steps.*.ingredients.*.name' => ['nullable', 'string'],


        ];
    }

    // protected function prepareForValidation()
    // {
    //     $this->merge([
    //         // 'number_people' => $this->numberPeople,
    //         // 'image_url' => $this->imageUrl,
    //         // 'user_id' => $this->userId,
    //         'recipe_steps' => $this->recipeSteps

    //     ]);
    // }
}
