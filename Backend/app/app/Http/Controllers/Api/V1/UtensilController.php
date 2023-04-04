<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Utensil;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUtensilRequest;
use App\Http\Resources\V1\UtensilCollection;
use App\Http\Resources\V1\UtensilResource;
use App\Models\UtensilCategory;

class UtensilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new UtensilCollection(Utensil::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUtensilRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUtensilRequest $request)
    {
        $utensil = Utensil::firstOrCreate(['name' => $request->name]);

        if ($request->has('utensilCategoryId')) {
            $categoryUtensil = UtensilCategory::findOrFail($request->utensilCategoryId);
            $utensil->utensilCategories()->syncWithoutDetaching($categoryUtensil->id);
        }

        return new UtensilResource($utensil);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Utensil  $utensil
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Utensil $utensil)
    {
        $utensilCategoryId = $request->input('utensilCategory');
        $category = UtensilCategory::find($utensilCategoryId);

        if (!$category) {
            return response()->json(['error' => 'Category not found']);
        }

        $attachedCategoryIds = $utensil->utensilCategories()->pluck('utensil_categories.id')->all();

        if (!in_array($utensilCategoryId, $attachedCategoryIds)) {
            return response()->json(['error' => 'Category is not attached to the utensil']);
        }

        $category->utensils()->detach($utensil->id);

        return response()->json(['success' => 'Utensil removed from category !']);
    }
}
