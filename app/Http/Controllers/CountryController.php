<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CountryController extends Controller
{
    public function index()
    {
        return view('country.index');
    }

    public function store(Request $request)
    {
        // 1️⃣ Validation
        $request->validate([
            'country_name' => 'required|unique:countries,country_name',
            'capital_city' => 'required',
        ], [
            'country_name.required' => 'Please enter country name',
            'country_name.unique' => 'Country name already exists',
            'capital_city.required' => 'Please enter capital city',
        ]);

        try {
            // 2️⃣ Store
            $country = Country::create([
                'country_name' => $request->country_name,
                'capital_city' => $request->capital_city,
            ]);

            // 3️⃣ Success
            if ($country) {
                return response()->json([
                    'status' => true,
                    'message' => 'Country created successfully',
                ]);
            }

            // If create return false
            return response()->json([
                'status' => false,
                'message' => 'Country not created',
            ], 500);

        } catch (\Throwable $e) {

            // 4️⃣ Any error
            return response()->json([
                'status' => false,
                'message' => 'Unexpected error occurred, please try again',
            ], 500);
        }
    }

    public function getCountries(Request $request)
    {
        if ($request->ajax()) {
            $data = Country::select(['id', 'country_name', 'capital_city'])->orderBy('country_name', 'asc');

            return DataTables::of($data)->addColumn('actions', function ($row) {
                return 'Edit | Delete';
            })->make(true);
        }
    }
}
