<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;
use App\City;
use App\District;

class IndoCtrl extends Controller
{
    public function provinsi(Request $request)
    {
        $provinsi = State::all();
        return response()->json($provinsi, 200);
    }

    public function city(Request $request, $state_id)
    {
        $city = City::where('state_id', $state_id)->get();
        return response()->json($city, 200);
    }

    public function district(Request $request, $city_id)
    {
        $district = District::where('city_id', $city_id)->get();
        return response()->json($district, 200);
    }
}
