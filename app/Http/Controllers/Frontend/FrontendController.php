<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Content;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\SectionTitle;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Carbon\Carbon;

class FrontendController extends Controller
{
    function index() : View {
        $sectionTitles = $this->getSectionTitles();

        $sliders = Slider::where('status', 1)->get();
        $content = Content::where('status', 1)->get();

        $categories = Category::where(['show_at_home' => 1, 'status' => 1])->get();

        return view('frontend.home.index', compact(
            'sliders',
            'sectionTitles',
            'content',
            'categories'
        ));
    }

    function getSectionTitles() : Collection {
        $key = [
            'content_top_title',
            'content_main_title',
            'content_sub_title'
        ];
        return SectionTitle::whereIn('key', $key)->pluck('value', 'key');
    }

    function showProduct(string $slug) : View{
        $product = Product::with(['productImages', 'productOptions', 'productAdds'])->where(['slug'=> $slug, 'status' => 1])->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)->take(8)->latest()->get();
        return view('frontend.pages.product-view', compact('product', 'relatedProducts'));
    }

    function loadProductModal($productId) {
        $product = Product::with(['productOptions', 'productAdds'])->findOrFail($productId);

        return view('frontend.layouts.ajax-files.product-popup-modal', compact('product'))->render();
    }

    public function applyCoupon(Request $request) {
        $subtotal = $request->subtotal;
        $code = $request->code;

        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return response(['status' => 'error', 'message' => 'Invalid Coupon Code'], 422);
        }

        if ($coupon->quantity <= 0) {
            return response(['status' => 'error', 'message' => 'Coupon has been fully redeemed'], 422);
        }

        if (Carbon::now()->gt($coupon->expire_date)) {
            return response(['status' => 'error', 'message' => 'Coupon has expired'], 422);
        }

        if ($coupon->discount_type === 'percent') {
            $discount = $subtotal * ($coupon->discount / 100);
        } elseif ($coupon->discount_type === 'amount') {
            $discount = $coupon->discount;
        } else {
            return response(['status' => 'error', 'message' => 'Invalid discount type'], 422);
        }

        $finalTotal = $subtotal - $discount;

        session()->put('coupon', ['code' => $code, 'discount' => $discount]);

        return response(['status' => 'Coupon Applied', 'discount' => $discount, 'finalTotal' => $finalTotal, 'coupon_code' => $code]);
    }


    function products(Request $request) : View {

        // Initialize the query with the status condition
        $products = Product::where('status', 1);

        // Check if the search parameter is present and filled
        if ($request->has('search') && $request->filled('search')) {
            $search = $request->search;
            $products->where(function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('long_description', 'like', '%' . $search . '%');
            });
        }

        // Check if the category parameter is present and filled
        if ($request->has('category') && $request->filled('category')) {
            $category = $request->category;
            $products->where(function($query) use ($category) {
                $query->where('category_id', $category);
            });
        }

        // Order the results by ID in descending order and paginate
        $products = $products->orderBy('id', 'DESC')->paginate(30);

        // Get all active categories
        $categories = Category::where('status', 1)->get();

        // Return the view with the products and categories
        return view('frontend.pages.product', compact('products', 'categories'));
    }

    function destroyCoupon(){
        try{
            session()->forget('coupon');

            return response(['message'=>'Coupon Removed!', 'grand_cart_total'=>grandCartTotal()]);
        }catch(\Exception $e){
            logger($e);
            return response(['message'=>'Something went wrong!']);
        }
    }
}

