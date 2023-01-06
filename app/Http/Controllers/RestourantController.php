<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Rating;
use App\Models\Restourant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RestourantController extends Controller
{
    public function index()
    {
        $restourants = Restourant::all();

        return response()->json($restourants, 200);
    }

    public function store(Request $request)
    {
        $fields = Validator::make($request->all(), [
            'title' => 'required|unique:restourants,title|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'hours' => 'required|string|max:255',

        ]);

        if ($fields->fails()) {
            return response()->json($fields->errors(), 400);
        }

        Restourant::create([
            'title' => $request->title,
            'city' => $request->city,
            'address' => $request->address,
            'hours' => $request->hours,
        ]);

        return response()->json(["message" => "Restaurant created!"], 202);
    }

    public function show($id)
    {
        $restourant = Restourant::find($id);
        $dishes = Dish::where('restourant_id', $id)->with('ratings')->get();

        foreach ($dishes as $dish) {
            $index = 0;
            $dishRatingSum = 0;
            $ratingCount = count($dish->ratings); 

            foreach ($dish->ratings as $dishRating) {
                $dishRatingSum = $dishRatingSum + $dishRating->rating;
            }

            if ($dishRatingSum !== 0) {
                $dishes[$index]->rating = round($dishRatingSum / $ratingCount, 2);
            }
            
            unset($dishes[$index]->ratings);

            $index++;
        }

        $restourant->dishes = $dishes;

        return response()->json($restourant, 200);
    }

    public function update(Request $request, $id)
    {
        $fields = Validator::make($request->all(), [
            'title' => 'unique:restourants,title|max:255',
            'city' => 'string|max:255',
            'address' => 'string|max:255',
            'hours' => 'string|max:255',
        ]);

        if ($fields->fails()) {
            return response()->json($fields->errors(), 400);
        }

        $restourant = Restourant::find($id);
        $restourant->update($request->all());

        return response()->json($restourant, 200);
    }

    public function destroy($id)
    {
        $isdeleted = Restourant::destroy($id);

        if ($isdeleted === 0) {
            return response()->json(["message" => "operation failed!"], 404);
        }

        return response()->json(["message" => "operation suscces!"], 200);
    }
}
