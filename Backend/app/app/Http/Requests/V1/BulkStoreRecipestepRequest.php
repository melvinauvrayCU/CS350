<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkStoreRecipestepRequest extends FormRequest
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
            '*.description' => ['required', 'string'],
            '*.cookTime' => ['required', 'string'],
            '*.prepTime' => ['required', 'string'],
            '*.recipeId' => ['required', 'integer']
        ];
    }

    protected function prepareForValidation()
    {
        $data = [];

        foreach ($this->toArray() as $obj) {
            $obj['cook_time'] = $obj['cookTime'] ?? null;
            $obj['prep_time'] = $obj['prepTime'] ?? null;
            $obj['recipe_id'] = $obj['recipeId'] ?? null;

            $data[] = $obj;
        }

        $this->merge($data);
    }
}
