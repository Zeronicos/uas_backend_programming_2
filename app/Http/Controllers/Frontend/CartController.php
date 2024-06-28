<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CartController extends Controller
{

    function index() : View {
        return view("frontend.pages.cart-view");
    }
    /**
     * Add product in to cart
    */
    function addToCart(Request $request){
        $product = Product::with(['productOptions', 'productAdds'])->findOrFail($request->product_id);
        if($product->quantity < $request->quantity){
            throw ValidationException::withMessages(['Quantity is not available']);
        }
        try {
            $productOption = $product->productOptions->where('id', $request->product_option)->first();
            $productAdds = $product->productAdds->whereIn('id', $request->product_add);

            $options = [
                'product_option'=> [],
                'product_add'=> [],
                'product_info' => [
                    'image' => $product->thumb_image,
                    'slug' => $product->slug,
                ]
            ];

            if($productOption !== null){
                $options['product_option'] = [
                    'id' => $productOption?->id,
                    'name' => $productOption?->name,
                    'price' => $productOption?->price,
                ];
            }

            foreach($productAdds as $option) {
                $options['product_add'][] = [
                    'id'=> $option->id,
                    'name'=> $option->name,
                    'price'=> $option->price,
                ];
            }

            Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $request->quantity,
                'price' => $product->offer_price > 0 ? $product->offer_price : $product->price,
                'weight' => 0,
                'options'=> $options,
            ]);
            return response(['status' => 'success', 'message' => 'Product added into cart!'], 200);
        } catch(\Exception $e){
            logger($e);
            return response(['status' => 'error', 'message' => 'Something went wrong!'], 500);
        }
    }

    function getCartProduct() {
        return view('frontend.layouts.ajax-files.sidebar-cart-item')->render();
    }

    function cartProductRemove($rowId) {
        try {
            Cart::remove($rowId);
            return response([
                'status' => 'success',
                'Item has been removed!',
                'cart_total'=>cartTotal(),
                'grand_cart_total' => grandCartTotal(),
            ], 200);
        }catch(\Exception $e){
            return response(['status' => 'error', 'Something went wrong!'], 500);
        }
    }

    function cartQtyUpdate(Request $request) : Response {
        $cartItem = Cart::get($request->rowId);
        $product = Product::findOrFail($cartItem->id);

        if($product->quantity < $request->qty){
            return response(['status' => 'error', 'message' => 'Quantity is not available', 'qty' => $cartItem->qty]);
        }

        try {
            $cart = Cart::update($request->rowId, $request->qty);
            return response([
                'status'=>'success',
                'product_total' => productTotal($request->rowId),
                'qty' => $cart->qty,
                'cart_total' => cartTotal(),
                'grand_cart_total' => grandCartTotal()]
                , 200);
        }catch(\Exception $e){
            logger($e);
            return response(['status' => 'error', 'message' => 'Something wnt wrong!'], 500);
        }
    }

    function cartDestroy() {
        Cart::destroy();
        session()->forget('coupon');
        return redirect()->back();
    }
}
