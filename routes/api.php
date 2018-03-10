<?php

use App\Category;
use Illuminate\Http\Request;
use App\Recipe;


Route::group(['middleware' => 'api'], function(){


    Route::get('recipes', function() {
        return Recipe::all();
    });


    Route::get('recipe/{id}', function($id){
        return Recipe::findOrFail($id);
    });

    Route::post('recipe/store', function(Request $request){

        return Recipe::create(['name' => $request->input(['name']), 'email' => $request->input(['email']),'category_id' => '1', 'food' => $request->input(['food']), 'recipe' => $request->input(['recipe'])]);

    });


    Route::patch('recipe/{id}', function(Request $request, $id){
        Recipe::findOrFail($id)->update(['name' => $request->input(['name']),'category_id' => '1', 'food' => $request->input(['food']), 'recipe' => $request->input(['recipe'])]);

});

    // Delete recipe
    Route::delete('recipe/{id}', function($id){
        return Recipe::destroy($id);
    });
});





Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
