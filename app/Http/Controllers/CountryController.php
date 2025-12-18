<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        return view('country.index');
    }

    public function store(Request $request){
        // 1- Validation
        $request->validate([
            'country_name' => 'required|unique:countries,country_name',
            'capital_city' => 'required',
        ], [
            'country_name.required' => 'Please enter country name',
            'country_name.unique' => 'Country name already exists',
            'capital_city.required' => 'Please enter capital city',
        ]);

        // 2- Store
        $country = Country::create([
            'country_name' => $request->country_name,
            'capital_city' => $request->capital_city,
        ]);

        // 3- Return response
        return response()->json([
            'status' => true,
            'message' => 'Country created successfully',
        ]);
    }
}
