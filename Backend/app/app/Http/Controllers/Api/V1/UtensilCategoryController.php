<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\UtensilCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUtensilCategoryRequest;
use App\Http\Resources\V1\UtensilCategoryCollection;
use App\Http\Resources\V1\UtensilCategoryResource;

class UtensilCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = $request->input('userId');

        if (!$userId) {
            return response()->json(['error' => 'User ID is required.'], 400);
        }

        $utensilCategories = UtensilCategory::where('user_id', $userId)->get();

        return new UtensilCategoryCollection($utensilCategories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUtensilCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUtensilCategoryRequest $request)
    {
        return new UtensilCategoryResource(UtensilCategory::create($request->all()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UtensilCategory  $utensilCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $utensilCategory = UtensilCategory::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Utensil category not found'], 404);
        }

        try {
            $utensilCategory->delete();
            return response()->json(['success' => 'Utensil category deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete utensil category'], 500);
        }
    }
}
