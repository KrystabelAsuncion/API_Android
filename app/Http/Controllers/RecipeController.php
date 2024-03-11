<?php

namespace App\Http\Controllers;

use App\Models\RecipeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        // Retrieve the recipe
        $recipe = RecipeModel::findOrFail($id);

        // Increment the views count for the recipe
        DB::table('recipes')->where('id', $id)->increment('views');
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

    public function lunchCategory()
    {
        $recipes = RecipeModel::where('category', 'lunch')->get();

        return response()->json($recipes);
    }

    public function dinnerCategory()
    {
        $recipes = RecipeModel::where('category', 'dinner')->get();

        return response()->json($recipes);
    }

    public function snackCategory()
    {
        $recipes = RecipeModel::where('category', 'snacks')->get();

        return response()->json($recipes);
    }

    public function recentRecipe()
    {
        // Retrieve the most recent recipe from the database
        $recentRecipe = RecipeModel::latest()->take(5)->get();

        return response()->json($recentRecipe, 200);
    }

    public function mostViewed()
    {
        // Retrieve the recipe with the highest count of views
        $mostViewedRecipe = RecipeModel::orderBy('views', 'desc')->take(5)->get();

        return response()->json($mostViewedRecipe, 200);
    }
}
