<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAdd;
use App\Models\ProductOption;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ProductOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $productId) : View
    {
        $product = Product::findOrFail($productId);
        $options = ProductOption::where('product_id', $product->id)->get();
        $adds = ProductAdd::where('product_id', $product->id)->get();
        return view('admin.product.product-option.index', compact('product', 'options', 'adds'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'price' => ['required', 'numeric'],
        ]);

        $option = new ProductOption();

        $option->product_id = $request->product_id;
        $option->name = $request->name;
        $option->price = $request->price;
        $option->save();

        flash()->success('Created Successfully');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : Response
    {
        try{
            $image = ProductOption::findOrFail($id);
            $image->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully']);
        }catch(\Exception $e){
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
