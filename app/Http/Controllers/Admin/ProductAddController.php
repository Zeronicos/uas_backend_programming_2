<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductAdd;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductAddController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'price' => ['required', 'numeric'],
            'product_id' => ['required', 'integer'],
        ], [
            'name.required' => 'Product add-ons is required',
            'name.max' => 'Product add-ons max length is 255',
            'price.required' => 'Price add-ons is required',
            'price.numeric' => 'Price add-ons price must be number',
        ]);

        $add = new ProductAdd();
        $add->product_id = $request->product_id;
        $add->name = $request->name;
        $add->price = $request->price;
        $add->save();

        flash()->success('Created Successfully');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : Response
    {
        try{
            $image = ProductAdd::findOrFail($id);
            $image->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully']);
        }catch(\Exception $e){
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
