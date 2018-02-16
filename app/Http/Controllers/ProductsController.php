<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    public function index() {
        return Product::latest()->get();
    }

    public function store(Request $request) {

        $exploded = explode(',', $request->image);

        $decoded = base64_decode($exploded[1]);

        if(str_contains($exploded[0], 'jpeg' ))
            $extension = 'jpg';
        else if(str_contains($exploded[0], 'png' ))
            $extension = 'png';

        $fileName = str_random().'.'.$extension;

        $path = public_path().'/'.$fileName;

        file_put_contents($path, $decoded);

        $product = Product::create(
            $request->except('image') +
            [
                'user_id' => Auth::id(),
                'image' => $fileName
            ]
        );
        return $product;
    }

    public function destroy($id) {
        try {
            Product::destroy($id);
            return response([], 204);
        } catch (\Exception $e) {
            return response(['Problem deleting product'], 500);
        }

    }

    public function show($id) {
        return Product::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $product = Product::find($id);

        $product->update($request->all());

        return $product;
    }


}
