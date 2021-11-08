<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;
use App\Http\Requests\FoodRequest;

class FoodController extends Controller
{
    // API Get Data Food All
    public function all(Request $request)
    {
        // Create Parameter Food Filter
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $name = $request->input('name');
        $types = $request->input('types');

        // Create Parameter Food by Price
        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');

        // Create Parameter Food by Rate
        $rate_from = $request->input('rate_from');
        $rate_to = $request->input('rate_to');

        // Get Data Food By id
        if ($id) {
            $food = Food::find($id);
            if ($food) {
                return ResponseFormatter::success(
                    $food,
                    'Success Get Data Food By ID'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data Food Not Found',
                    404
                );
            }
        }

        $query = array();
        // Get Data Food By Name
        if ($name) {
            array_push($query,['name', 'like', '%' . $name . '%']);
        }

        // Get Data Food By Types
        if ($types) {
            array_push($query,['types', 'like', '%' . $types . '%']);
        }

        // Get Data Food By Price From
        if ($price_from) {
            array_push($query,['price', '>=', $price_from]);
        }

        // Get Data Food By Price To
        if ($price_to) {
            array_push($query,['price', '<=', $price_to]);
        }

        // Get Data Food By Price Rate From
        if ($rate_from) {
            array_push($query,['rate', '>=', $rate_from]);
        }

        // Get Data Food By Price Rate to
        if ($rate_to) {
            array_push($query,['rate', '>=', $rate_to]);
        }
        $result = Food::where($query)->paginate($limit);
        // Response Data
        return ResponseFormatter::success(
            $result,
            'Success Get Data List Food'
        );
    }

    // API Store Data Food
    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('picturePath')) {
            $data['picturePath'] = $request->file('picturePath')->store('assets/food', 'public');
        }

        $result = Food::create($data);

        return ResponseFormatter::success(
            $result,
            'Success Store Food Data'
        );
    }

    public function update(FoodRequest $request, Food $food)
    {
        $data = $request->all();

        if ($request->file('picturePath')) {
            $data['picturePath'] = $request->file('picturePath')->store('assets/food', 'public');
        }

        $food->update($data);

        return ResponseFormatter::success(
            $food,
            'Success Update Food Data'
        );
    }
}
