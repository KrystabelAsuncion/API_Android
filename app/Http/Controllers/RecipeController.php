<?php

namespace App\Http\Controllers;

use App\Models\RecipeModel;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function storeRecipe(Request $request)
    {
        $request->validate([
            'recipe_name' => 'required',
            'recipe_description' => 'required',
            'category' => 'required|in:breakfast,lunch,dinner,snacks',
            'steps' => 'required',
            'ingredients' => 'required'
        ]);

       $recipe = new RecipeModel();
       $recipe->recipe_name = $request->recipe_name;
       $recipe->recipe_description = $request->recipe_description;
       $recipe->category = $request->category;
       $recipe->steps = $request->steps;
       $recipe->ingredients = $request->ingredients;
       $recipe->save();

       return response()->json([
        'status' => 'success',
        'message' => 'created successfully',
        'data' => $recipe
       ]);
    }
    public function index()
    {
        $recipes = RecipeModel::all();

        $recipes = $recipes->map(function ($recipe) {
            $recipe->steps = explode(',', $recipe->steps);
            $recipe->ingredients = explode(',', $recipe->ingredients);
            return $recipe;
        });

        return response()->json([
            'status' => true,
            'recipes' => $recipes
        ]);

    }
    public function showRecipe($id)
    {
        $recipe = RecipeModel::findByID($id);
        return response()->json([
            'status' => true,
            'message' => 'Recipe found',
            'result' => $recipe
        ]);
    }

    public function editRecipe(Request $request, $id)
    {
        $request->validate([
            'recipe_name' => 'required',
            'recipe_description' => 'required',
            'category' => 'required|in:breakfast,lunch,dinner,snacks',
            'steps' => 'required',
            'ingredients' => 'required'
        ]);

        $recipe = RecipeModel::findOrFail($id);

        $recipe->recipe_name = $request->recipe_name;
        $recipe->recipe_description = $request->recipe_description;
        $recipe->category = $request->category;
        $recipe->steps = $request->steps;
        $recipe->ingredients = $request->ingredients;
        $recipe->save();

        return response()->json([
            'status' => true,
            'message' => 'edited successfully',
            'result' => $recipe
        ]);
    }
    public function deleteRecipe($id)
    {
        $recipe = RecipeModel::findOrFail($id);

        $recipe->delete();

        return response()->json(['message' => 'Recipe deleted successfully'], 200);
    }

    public function breakfastCategory()
    {
        // Retrieve recipes with category "breakfast" from the database
        $recipes = RecipeModel::where('category', 'breakfast')->get();

        // Return the retrieved recipes as JSON response
        return response()->json($recipes);
    }


}
