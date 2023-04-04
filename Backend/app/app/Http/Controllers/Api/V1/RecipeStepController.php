<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecipeStepRequest;
use App\Http\Requests\UpdateRecipeStepRequest;
use App\Models\RecipeStep;
use App\Http\Resources\V1\RecipeStepResource;
use App\Http\Resources\V1\RecipeStepCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Http\Requests\V1\BulkStoreRecipestepRequest;

class RecipeStepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new RecipeStepCollection(RecipeStep::paginate());
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRecipeStepRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRecipeStepRequest $request)
    {
        return new RecipeStepResource(RecipeStep::create($request->all()));
    }

    public function bulkStore(BulkStoreRecipestepRequest $request)
    {
        $bulk = collect($request->all())->map(function ($arr, $key) {
            return Arr::except($arr, ['cookTime', 'prepTime', 'recipeId', 'ingredients', 'utensils']);
        });

        RecipeStep::insert($bulk->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RecipeStep  $recipeStep
     * @return \Illuminate\Http\Response
     */
    public function show(RecipeStep $recipestep)
    {
        return new RecipeStepResource($recipestep);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRecipeStepRequest  $request
     * @param  \App\Models\RecipeStep  $recipeStep
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRecipeStepRequest $request, RecipeStep $recipeStep)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RecipeStep  $recipeStep
     * @return \Illuminate\Http\Response
     */
    public function destroy(RecipeStep $recipeStep)
    {
        //
    }
}
