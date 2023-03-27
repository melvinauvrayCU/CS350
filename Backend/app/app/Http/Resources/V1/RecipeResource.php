<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\V1\UserResource;

class RecipeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'numberPeople' => $this->number_people,
            'rating' => $this->rating,
            'imageUrl' => $this->image_url,
            'recipeSteps' => $this->recipe_steps,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];

        if ($this->whenLoaded('user')) {
            $data['user'] = new UserResource($this->user);
        }

        return $data;
    }
}
