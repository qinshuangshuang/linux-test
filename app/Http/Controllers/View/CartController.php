<?php

namespace App\Http\Controllers\View;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Entity\Product;
use App\Entity\CartItem;
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

        $member = $request->session()->get('member', '');
        if($member != ''){
            $carts = $this->synCart($member->id, $cart_arr);
            return response()->view('cart', ['carts'=>$carts])->withCookie('cart', null);
        }

        $cart_items = array();
        foreach ($cart_arr as $key => $value) {
              $cart_item = new CartItem;
              $id_arr = explode(':', $value);
              $cart_item->id = $key;
              $cart_item->product_id = $id_arr[0];
              $cart_item->count = $id_arr[1];
              $cart_item->product = Product::find($cart_item->product_id);
              if($cart_item->product != null) {
                array_push($cart_items, $cart_item);
              }
         }

        return view('cart')->with('carts', $cart_items);
    }
   
    // private function synCart($member_id, $cart_arr){
    //     $cart_item = CartItem::where('member_id', $member_id);
    //     $cart_items = array();
    //     foreach ($cart_arr as $key => $value) {
    //         $id_arr = explode(':', $value);
    //         $product_id = $id_arr[0];
    //         $num = $id_arr[1];
            
    //         $exists = false;
    //         foreach ($cart_item as $key => $value) {
    //             if($value->product_id == $product_id){
    //                 if($value->count < $num){
    //                     $value->count = $num;
    //                     $value->save();
    //                 }
    //                 $exists = true;
    //                 break;
    //             }
    //         }
    //         if($exists == false){
    //             $cart_item = new CartItem;
    //             $cart_item->member_id = $member_id;
    //             $cart_item->product_id = $product_id;
    //             $cart_item->count = $num;
    //             $cart_item->save();
    //             $cart_item->product = Product::find($cart_item->product_id);
    //             array_push($cart_items, $cart_item);
    //         }

    //         foreach ($cart_items as $key => &$value) {
    //             $value->product = Product::find($value->product_id);
    //         }

    //      }
    //     return $cart_items;

    // }

      private function synCart($member_id, $bk_cart_arr){
            $cart_items = CartItem::where('member_id', $member_id)->get();

            $cart_items_arr = array();
            foreach ($bk_cart_arr as $value) {
              $index = strpos($value, ':');
              $product_id = substr($value, 0, $index);
              $count = (int) substr($value, $index+1);

              // 判断离线购物车中product_id 是否存在 数据库中
              $exist = false;
              foreach ($cart_items as $temp) {
                if($temp->product_id == $product_id) {
                  if($temp->count < $count) {
                    $temp->count = $count;
                    $temp->save();
                  }
                  $exist = true;
                  break;
                }
              }

              // 不存在则存储进来
              if($exist == false) {
                $cart_item = new CartItem;
                $cart_item->member_id = $member_id;
                $cart_item->product_id = $product_id;
                $cart_item->count = $count;
                $cart_item->save();
                $cart_item->product = Product::find($cart_item->product_id);
                array_push($cart_items_arr, $cart_item);
              }
            }

            // 为每个对象附加产品对象便于显示
            foreach ($cart_items as $cart_item) {
              $cart_item->product = Product::find($cart_item->product_id);
              array_push($cart_items_arr, $cart_item);
            }

            return $cart_items_arr;
          }

}
