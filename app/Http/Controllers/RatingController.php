<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $fields = Validator::make($request->all(), [
            'rating' => 'required|integer|max:10|min:1',
            'dish_id' => 'required|integer'
        ]);

        if ($fields->fails()) {
            return response()->json($fields->errors(), 400);
        }

        $rating = new Rating();
        $rating->rating = $request->rating;

        $dish = Dish::find($request->dish_id);
        $dish->ratings()->save($rating);

        return response()->json(["message" => "Rating added!"], 202);
    }

}
