<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => Product::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
        ]);

        $product = new Product();
        $product->create([
            'name' => $request->name ,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully Inserted',
            'data' => Product::all(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product,$id)
    {
        return response()->json([
            'status' => 'success',
            'data' => Product::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product,$id)
    {
        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->name ,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully Updated',
            'data' => $product,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product,$id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully Deleted',
            'data' => Product::all(),
        ]);
    }

     /**
     * search product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        $products = Product::where('name' ,'like','%'.$name.'%')->get();
        return response()->json([
            'status' => 'success',
            'data' => $products,
        ]);
    }
}
