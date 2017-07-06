<?php

namespace App\Http\Controllers\View;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\PdtContent;
use App\Entity\CartItem;
use App\Entity\Order;
use App\Entity\OrderItem; 
use App\Models\M3Result;

class OrderController extends Controller
{
   
    public function toOrderPay(Request $request)
    {
    	$cart = $request->cookie('cart');
        if($cart){
            $cart_arr = explode(',', $cart);
        }else{
            $cart_arr = array();
        }

        $member = $request->session()->get('member', '');
        if($member != ''){
            $carts = $this->synCart($member->id, $cart_arr);
            return response()->view('order_pay', ['carts'=>$carts])->withCookie('cart', null);
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
        return view('order_pay')->with('carts', $cart_items);
    }

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

    public function toOrderCommit(Request $request, $ids){
        if($ids){
            $ids_arr = explode(',', $ids);
        }else{
            $ids_arr = array();
        }
        $member = $request->session()->get('member', '');
        if($member){
            $member_id = $member->id;
        }

        $cart_items = CartItem::where('member_id', $member->id)->get();
        // $cart_items = CartItem::where('member_id',$member_id)->whereIn('product_id', $ids_arr )->get();
        // var_dump($cart_items);

        $total_price = 0;
        foreach ($cart_items as $key => &$cart_item) {
            $cart_item->product = Product::find($cart_item->product_id);
            $total_price += $cart_item->product->price * $cart_item->count;
              // array_push($cart_items, $cart_item);
        }

        // var_dump($cart_items);
        return view('order_commit')->with(['carts'=>$cart_items, 'total_price'=>$total_price]);
    }

    public function toOrderList(Request $request){
        $member = $request->session()->get('member', '');
        if($member){
            $member_id = $member->id;
        }

        $total_count = 0;
        $order_list = Order::where('member_id', $member->id)->get();
        foreach ($order_list as $key => &$order) {
            $order_id = $order->id;
            $order->orderItem = OrderItem::where('order_id', $order_id)->get();
            foreach ($order->orderItem as $k => &$v) {
                $v->product = Product::where('id', $v->product_id)->first();
                $total_count = $v->count;
            }
            $order->total_count = $total_count;

        }

        // return $order_list;
        return view('order_list')->with('order_list', $order_list);

    }
}
