<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Entity\Category;
use App\Entity\PdtContent;
use App\Models\M3Result;

class CartController extends Controller
{
   
    public function addCart(Request $request, $product_id){
    	// product_id:num , product_id:num , product_id:num 
        $cart = $request->cookie('cart');
        if($cart){
            $cart_arr = explode(',', $cart);
        }else{
            $cart_arr = array();
        }
        $flag = '0';
        foreach ($cart_arr as $key => &$value) {
            $id_arr = explode(':', $value);
            $id = $id_arr[0];
            if($id == $product_id){
                $num = $id_arr[1];
                $num = (int)($num) + 1;
                $value = $id . ':' . $num; 
                $flag = '1';
                break;
            }
        }
        //没找到
        if($flag == '0'){
            $val = $product_id . ':1'; 
            array_push($cart_arr, $val);
        }
        $m3_result = new M3Result;
        $m3_result->status = 0;
        $m3_result->message = "请求成功";
        $m3_result->cart = $cart_arr;
        return response($m3_result->toJson())->withCookie(cookie('cart', implode(',',$cart_arr))) ;
    	
    }

    public function delCart(Request $request){
        $ids = $request->input('ids');
        $id_arr = explode(",", $ids);

        $cart = $request->cookie('cart');
        if($cart){
            $cart_arr = explode(',', $cart);
        }else{
            $cart_arr = array();
        }

        foreach ($cart_arr as $key => $cart) {
            $id = explode(":", $cart)[0];
            if( in_array($id, $id_arr) ){
                unset( $cart_arr[$key] );
            }
        }

        $m3_result = new M3Result;
        $m3_result->status = 0;
        $m3_result->message = "删除成功";
        return response($m3_result->toJson())->withCookie(cookie('cart', implode(',',$cart_arr))) ;
        
    }
   
 
}
