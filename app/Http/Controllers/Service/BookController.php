<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Entity\Category;
use App\Entity\PdtContent;
use App\Models\M3Result;

class BookController extends Controller
{
   
    public function getCategory(Request $request){
    	$parent_id = $request->input('parent_id');
    	$categorys = Category::where('parent_id', $parent_id)->get();
    	$m3_result = new M3Result;
    	if($categorys){
	    	$m3_result->status = 0;
		    $m3_result->message = "请求成功";
		    $m3_result->categorys = $categorys;
		    return $m3_result->toJson();
    	}else{
		    $m3_result->status = 1;
		    $m3_result->message = '暂无数据';
		    return $m3_result->toJson();
    	}
    }
   
    public function getContent(Request $request){
        $product_id = $request->input('product_id');
        $product = PdtContent::where('product_id', $product_id)->first();
        $m3_result = new M3Result;
        $m3_result->content = $product;
        return $m3_result->toJson();

        if($product){
            $m3_result->status = 0;
            $m3_result->message = "请求成功";
            $m3_result->content = $product->content;
            return $m3_result->toJson();
        }else{
            $m3_result->status = 1;
            $m3_result->message = '暂无数据';
            return $m3_result->toJson();
        }
    } 
   
   
}
