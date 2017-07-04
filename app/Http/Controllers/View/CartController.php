<?php

namespace App\Http\Controllers\View;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Entity\Product;
use App\Models\M3Result;

class CartController extends Controller
{
   
    public function toCart(Request $request){
        $cart = $request->cookie('cart');
        if($cart){
            $cart_arr = explode(',', $cart);
        }else{
            $cart_arr = array();
        }

        $result = array();
        foreach ($cart_arr as $key => $value) {
            $id_arr = explode(':', $value);
            $tmp['product_id'] = $id_arr[0];
            $num = $id_arr[1];
            $product = Product::find( $id_arr[0] );
            // $tmp['name'] = $product['name'];
            // $tmp['preview'] = $product['preview'];
            // $tmp['price'] = $product['price'];
            // $tmp['summary'] = $product['summary'];
            $product->num = $num;
            $result[] = $product;
         }

        return view('cart')->with('carts', $result);
    }
   
 
}
