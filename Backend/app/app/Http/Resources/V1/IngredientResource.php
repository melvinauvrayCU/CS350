<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class IngredientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'quantity' => $this->whenPivotLoaded('recipe_step_ingredient', function () {
                return $this->pivot->quantity;
            }),
            'measurement' => $this->whenPivotLoaded('recipe_step_ingredient', function () {
                return $this->pivot->measurement;
            }),
        ];
    }
}
