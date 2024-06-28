<?php

/** Create unique slug */

use Gloudemans\Shoppingcart\Facades\Cart;

if(!function_exists('generateUniqueSlug')){
    function generateUniqueSlug($model, $name) : string
    {
        $modelClass="App\\Models\\$model";

        if(!class_exists($modelClass)){
            throw new \InvalidArgumentException("Model $model not found.");
        }

        $slug = \Str::slug($name);
        $count = 1;

        while($modelClass::where('slug', $slug)->exists()){
            $slug = \Str::slug($name). '-' .$count;
            $count++;
        }

        return $slug;
    }
}

if(!function_exists('currencyPosition')){
    function currencyPosition($price) : string {
        if(config('settings.site_currency_icon_position') === 'left'){
            return $price . config('settings.site_currency_icon');
        }else{
            return config('settings.site_currency_icon').$price;
        }
    }
}

//** Calculate Cart Total Price */
if(!function_exists('cartTotal')){
    function cartTotal() {
        $total = 0;

        foreach(Cart::content() as $item) {
            $productPrice = $item->price;
            $optionPrice = $item->options?->product_option['price'] ?? 0;
            $addsPrice = 0;
            foreach($item->options->product_add as $add) {
                $addsPrice += $add['price'];
            }
            $total += ($productPrice + $optionPrice + $addsPrice) * $item->qty;
        }

        return $total;
    }
}

//** Calculate product Total Price */
if(!function_exists('productTotal')){
    function productTotal($rowId) {
        $total = 0;

        $product = Cart::get($rowId);

        $productPrice = $product->price;
        $optionPrice = $product->options?->product_option['price'] ?? 0;
        $addsPrice = 0;

        foreach($product->options->product_add as $add) {
            $addsPrice += $add['price'];
        }
        $total += ($productPrice + $optionPrice + $addsPrice) * $product->qty;


        return $total;
    }
}

//** Grand Cart Total */
if(!function_exists('grandCartTotal')){
    function grandCartTotal() {
        $total = 0;
        $cartTotal = cartTotal();

        if(session()->has('coupon')){
            $discount = session()->get('coupon')['discount'];
            $total = $cartTotal - $discount;

            return $total;
        }else {
            $total = $cartTotal;
            return $total;
        }
    }
}

