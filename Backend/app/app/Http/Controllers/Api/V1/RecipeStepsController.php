<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreRecipeStepsRequest;
use App\Http\Requests\UpdateRecipeStepsRequest;
use App\Http\Controllers\Controller;
use App\Models\RecipeSteps;
use App\Http\Resources\V1\RecipeStepResource;
use App\Http\Resources\V1\RecipeStepsCollection;

class RecipeStepsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new RecipeStepsCollection(RecipeSteps::paginate());
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
     * @param  \App\Http\Requests\StoreRecipeStepsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRecipeStepsRequest $request)
    {
        return new RecipeStepResource(RecipeSteps::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RecipeSteps  $recipeSteps
     * @return \Illuminate\Http\Response
     */
    public function show(RecipeSteps $recipeSteps)
    {
        return new RecipeStepResource($recipeSteps);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RecipeSteps  $recipeSteps
     * @return \Illuminate\Http\Response
     */
    public function edit(RecipeSteps $recipeSteps)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRecipeStepsRequest  $request
     * @param  \App\Models\RecipeSteps  $recipeSteps
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRecipeStepsRequest $request, RecipeSteps $recipeSteps)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RecipeSteps  $recipeSteps
     * @return \Illuminate\Http\Response
     */
    public function destroy(RecipeSteps $recipeSteps)
    {
        //
    }
}
