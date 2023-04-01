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
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'numberPeople' => 'required|integer|min:1',
            'rating' => 'required|integer|min:1|max:5',
            '*.recipe_steps' => 'required|array|min:1',
            'imageUrl' => 'string',
            'userId' => ['required'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'number_people' => $this->numberPeople,
            'image_url' => $this->imageUrl,
            'user_id' => $this->userId,
            'recipe_steps' => $this->recipeSteps

        ]);
    }
}
