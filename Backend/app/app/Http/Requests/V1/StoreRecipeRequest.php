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
            'title' => ['required'],
            'description' => ['required'],
            'numberPeople' => ['required'],
            'rating' => ['required'],
            'userId' => ['required'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'number_people' => $this->numberPeople,
            'user_id' => $this->userId,
        ]);
    }
}
