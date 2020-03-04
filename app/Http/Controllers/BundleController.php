<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bundle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BundleController extends Controller
{
    public function store(Request $request)
    {

        $bundle = new Bundle;
        $bundle->name = $request->name;
        $bundle->products = json_encode($request->products);
        $bundle->description = $request->description;
        $bundle->created_by = Auth::user()->username;
        $bundle->is_active = 1;

        $pricetag = DB::table('products')
            -> whereIn('id', $request->products)
            -> sum('unit_price');

        $bundle->total_price = $pricetag;

        if ($bundle->save()) {
            flash(__('Media Bundle Package has been inserted successfully'))->success();
            return redirect()->route('products.bundle.index');
        } else {
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    public function updateActive(Request $request)
    {
        $bundle = Bundle::findOrFail($request->id);
        $bundle->is_active = $request->status;
        if($bundle->save()){
            return 1;
        }
        return 0;
    }

}
