<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class RecipeStepResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [
            'id' => $this->id,
            'description' => $this->description,
            'cookTime' => $this->cook_time,
            'prepTime' => $this->prep_time,
            'ingredients' => new IngredientCollection($this->ingredients),
            'recipeId' => $this->recipe_id
        ];
    }
}
