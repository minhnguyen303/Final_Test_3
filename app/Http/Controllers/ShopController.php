<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::all();
        return view('index', compact('shops'));
    }

    public function create(Request $request)
    {
        $shop = new Shop();
        $shop->name = $request->name;
        $shop->phone = $request->phone;
        $shop->email = $request->email;
        $shop->address = $request->address;
        $shop->master = $request->master;
        $shop->status = $request->status;
        $shop->save();

        return response()->json($shop);
    }

    public function read($id)
    {
        $shop = Shop::find($id);

        return response()->json($shop);
    }

    public function update(Request $request)
    {
        $shop = Shop::find($request->id);
        $shop->name = $request->name;
        $shop->phone = $request->phone;
        $shop->email = $request->email;
        $shop->address = $request->address;
        $shop->master = $request->master;
        $shop->status = $request->status;
        $shop->save();

        return response()->json($shop);
    }

    public function delete($id)
    {
        $shop = Shop::find($id);
        $shop->delete();

        return response()->json($id);
    }
}
