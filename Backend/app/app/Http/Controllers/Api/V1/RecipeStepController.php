<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecipeStepRequest;
use App\Http\Requests\UpdateRecipeStepRequest;
use App\Models\RecipeStep;
use App\Http\Resources\V1\RecipeStepResource;
use App\Http\Resources\V1\RecipeStepCollection;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RecipeStep  $recipeStep
     * @return \Illuminate\Http\Response
     */
    public function edit(RecipeStep $recipeStep)
    {
        //
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
