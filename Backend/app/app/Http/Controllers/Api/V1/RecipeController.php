<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Recipe;
use App\Models\RecipeStep;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreRecipeRequest;
use App\Http\Requests\V1\UpdateRecipeRequest;
use App\Http\Resources\V1\RecipeResource;
use App\Http\Resources\V1\RecipeCollection;
use Illuminate\Http\Request;
use App\Filters\V1\RecipeFilter;
use App\Models\Ingredient;
use App\Models\Utensil;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

/**
 * Class that handles the different requests method for the /recipes/ endpoint
 */
class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id = null)
    {
        $filter = new RecipeFilter();
        $filterItems = $filter->transform($request);

        $includeUser = $request->query('includeUser');

        $recipes = Recipe::where($filterItems);

        if ($includeUser) {
            $recipes = $recipes->with('user');
        }

        return new RecipeCollection($recipes->paginate()->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRecipeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRecipeRequest $request)
    {
        $recipeData = $request->only([
            'title',
            'description',
            'number_people',
            'image_url',
            'rating',
            'user_id'
        ]);

        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $filename = time() . '.' . $image->getClientOriginalExtension();

            // Use Intervention Image to resize and compress the image
            $imgSmall = Image::make($image->getRealPath());
            $imgSmall->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode('jpg', 75)->save(public_path('images/mini/' . $filename));

            $imgBanner = Image::make($image->getRealPath());
            $imgBanner->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode('jpg', 75)->save(public_path('images/banner/' . $filename));

            $recipeData['image_url'] = $filename;
        }

        $recipe = Recipe::create($recipeData);

        $stepsData = $request->input('recipe_steps', []);

        collect($stepsData)->map(function ($stepData) use (&$recipe) {
            $newstep = new RecipeStep([
                'description' => $stepData['description'],
                'prep_time' => $stepData['prep_time'],
                'cook_time' => $stepData['cook_time']
            ]);

            $recipe->recipeSteps()->save($newstep);

            if (isset($stepData['ingredients'])) {
                collect($stepData['ingredients'])->map(function ($ingredientData) use ($newstep) {
                    $ingredient = Ingredient::firstOrCreate(['name' => $ingredientData["name"]]);
                    $quantity = $ingredientData["quantity"];
                    $measurement = $ingredientData["measurement"];
                    $ingredient->recipeSteps()->syncWithoutDetaching([$newstep->id => ['quantity' => $quantity, 'measurement' => $measurement]]);
                });
            }

            if (isset($stepData['utensils'])) {
                collect($stepData['utensils'])->map(function ($utensilData) use ($newstep) {
                    $utensil = Utensil::firstOrCreate(['name' => $utensilData["name"]]);
                    $utensil->recipeSteps()->syncWithoutDetaching($newstep->id);
                });
            }

            return $newstep;
        });

        return new RecipeResource($recipe);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show(Recipe $recipe)
    {
        return new RecipeResource($recipe);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRecipeRequest  $request
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        $recipeData = $request->only([
            'title',
            'description',
            'number_people',
            'rating',
        ]);

        if ($request->hasFile('image_url')) {

            // Get the file path of the image to be deleted
            $imagePath = $recipe->image_url;

            // Delete the image from the server
            if (!empty($imagePath)) {
                Storage::delete(public_path('images/banner/' . $imagePath));
                Storage::delete(public_path('images/mini/' . $imagePath));
            }

            $image = $request->file('image_url');
            $filename = time() . '.' . $image->getClientOriginalExtension();

            // Use Intervention Image to resize and compress the image
            $imgSmall = Image::make($image->getRealPath());
            $imgSmall->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode('jpg', 75)->save(public_path('images/mini/' . $filename));

            $imgBanner = Image::make($image->getRealPath());
            $imgBanner->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode('jpg', 75)->save(public_path('images/banner/' . $filename));

            $recipeData['image_url'] = $filename;
        }

        $recipe->update($recipeData);

        $recipe->recipeSteps()->delete(); // remove existing recipe steps

        $stepsData = $request->input('recipe_steps', []);

        collect($stepsData)->map(function ($stepData) use ($recipe) {
            $newstep = new RecipeStep([
                'description' => $stepData['description'],
                'prep_time' => $stepData['prep_time'],
                'cook_time' => $stepData['cook_time']
            ]);

            $recipe->recipeSteps()->save($newstep); // add new recipe step to recipe

            if (isset($stepData['ingredients'])) {
                collect($stepData['ingredients'])->map(function ($ingredientData) use ($newstep) {
                    $ingredient = Ingredient::firstOrCreate(['name' => $ingredientData["name"]]);
                    $quantity = $ingredientData["quantity"];
                    $measurement = $ingredientData["measurement"];
                    $ingredient->recipeSteps()->syncWithoutDetaching([$newstep->id => ['quantity' => $quantity, 'measurement' => $measurement]]);
                });
            }

            if (isset($stepData['utensils'])) {
                collect($stepData['utensils'])->map(function ($utensilData) use ($newstep) {
                    $utensil = Utensil::firstOrCreate(['name' => $utensilData["name"]]);
                    $utensil->recipeSteps()->syncWithoutDetaching($newstep->id);
                });
            }
            return $newstep;
        });

        return new RecipeResource($recipe);
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe)
    {
        try {
            // Get the file path of the image to be deleted
            $imagePath = $recipe->image_url;

            // Delete the image from the server
            if (!empty($imagePath)) {
                Storage::delete(public_path('images/banner/' . $imagePath));
                Storage::delete(public_path('images/mini/' . $imagePath));
            }
            $recipe->delete();
            return response()->json(['success' => 'recipe deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete recipe'], 500);
        }
    }
}
