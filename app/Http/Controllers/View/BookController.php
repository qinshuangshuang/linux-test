<?php

namespace App\Http\Controllers\View;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\PdtContent;
use App\Entity\PdtImages;
use App\Entity\CartItem;
use Log;

class BookController extends Controller
{
    public function toCategory($value = ''){
        $categorys = Category::whereNull('parent_id')->get();
        return view('category')->with('categorys',$categorys);
    }

 	public function toProduct($category_id){
 		$products = Product::where('category_id', $category_id)->get();
 		return view('product')->with('products', $products);
 	}

 	public function toPdtContent(Request $request, $product_id){
 		$product = Product::find($product_id);
 		$pdt_content = PdtContent::where('product_id', $product_id)->first();
 		$pdt_image = PdtImages::where('product_id', $product_id)->get();
 		if( !$pdt_image ){
 			$pdt_image = array();
 		}
        if(!$pdt_content){
            $product->content = "";
        }else{
            $product->content = isset($pdt_content) ? $pdt_content->content : '' ;
        }
        $product->images = $pdt_image;


        $member = $request->session()->get('member', '');
        if($member != ''){
            $cart_items = CartItem::where('product_id', $product_id)->get();
            foreach ($cart_items as $cart_item) {
                if($cart_item->product_id == $product_id) {
                  $count = $cart_item->count;
                  break;
                }
            }
        }else{

     		$cart = $request->cookie('cart');
     		if($cart){
                $cart_arr = explode(',', $cart);
            }else{
                $cart_arr = array();
            }
            $count = 0;
            foreach ($cart_arr as $key => $value) {
                $id_arr = explode(':', $value);
                $id = $id_arr[0];
                if($id == $product_id){
                    $count = $id_arr[1];
                    break;
                }
            }
          	
        }    
     	$product->count = $count;
     	return view('pdt_content')->with('product', $product);
 	}
   
}
