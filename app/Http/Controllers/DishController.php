<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Rating;
use App\Models\Restourant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DishController extends Controller
{
    public function index()
    {
        $dish = Dish::all();

        return response()->json($dish, 200);
    }

    public function store(Request $request)
    {
        $fields = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'price' => 'required|numeric',
            'image' => 'optional|string|max:255',
            'restourant_id' => 'required|string|max:255'
        ]);

        if ($fields->fails()) {
            return response()->json($fields->errors(), 400);
        }

        $dish = new Dish();
        $dish->title = $request->title;
        $dish->price = $request->price;

        if ($request->image) {
            $dish->image = $request->image;
        }

        $restourant = Restourant::find($request->restourant_id);
        $restourant->dishes()->save($dish);

        return response()->json(["message" => "Dish added!"], 202);
    }

    public function show($id)
    {
        $dish = Dish::find($id);
        $dishRatings = Rating::where('dish_id', $id)->get();

        $ratingSum = 0;
        $dishRating = 0;

        foreach ($dishRatings as $rating) {
            $ratingSum = $rating->rating + $ratingSum;
        }

        if (count($dishRatings) !== 0) {
            $dishRating = number_format((float)$ratingSum / count($dishRatings), 2, ',', '');
        }

        $dish->rating = $dishRating;

        return response()->json($dish, 200);
    }

    public function update(Request $request, $id)
    {
        $fields = Validator::make($request->all(), [
            'title' => 'unique:restourants,title|max:255',
            'price' => 'numeric|max:255',
            'image' => 'string|max:255',

        ]);

        if ($fields->fails()) {
            return response()->json($fields->errors(), 400);
        }

        $dish = Dish::find($id);
        $dish->update($request->all());

        return response()->json($dish, 200);
    }

    public function destroy($id)
    {
        $isdeleted = Dish::destroy($id);

        if ($isdeleted === 0) {
            return response()->json(["message" => "operation failed!"], 404);
        }

        return response()->json(["message" => "operation suscces!"], 200);
    }
}
