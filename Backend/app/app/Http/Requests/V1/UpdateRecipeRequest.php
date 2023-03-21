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
        return true; // TODO: Change this
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
                'title' => ['required'],
                'description' => ['required'],
                'numberPeople' => ['required'],
                'rating' => ['required'],
            ];
        } else {
            // Method is PATCH
            return [
                'title' => ['sometimes', 'required'],
                'description' => ['sometimes', 'required'],
                'numberPeople' => ['sometimes', 'required'],
                'rating' => ['sometimes', 'required'],
            ];
        }
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
