<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\M3Result;
use App\Entity\Member;
use App\Entity\TempPhone;
use App\Entity\TempEmail;
use App\Models\M3Email;
use App\Tool\UUID;
use Mail;

class MemberController extends Controller
{
    public function register(Request $request){
     	$type = $request->input('type');
     	$phone = $request->input('phone');
     	$pcode = $request->input('pcode');
     	$password = $request->input('password');
     	$re_password = $request->input('re_password');
     	$email = $request->input('email');
     	$vcode = $request->input('vcode');
     	$m3_result = new M3Result;

     	if($phone != ''){
     		//手机号注册,验证手机验证码，通过可注册
		      if( strlen($phone)==0 || strlen($pcode)==0  ){
		          $m3_result->status = 1;
		          $m3_result->message = '手机号或验证码不能为空';
		          return $m3_result->toJson();
		      }

		      $tempPhone = TempPhone::where('phone', $phone)->first();
		      if( strtotime($tempPhone['deadline']) > time() ){
		          if($tempPhone['code'] == $pcode ){
		              // 手机验证码通过验证;
		          	  if(Member::where('phone', $phone)->first()){
		          	  	  $m3_result->status = 1;
			              $m3_result->message = '此手机号已注册！';
			              return $m3_result->toJson();
		          	  }else{
		          	  	  $member = new Member();
		          	  	  $member->phone = $phone;
			          	  $member->password = md5($password + 'laravel');
			          	  $member->save();
			          	  $m3_result->status = 0;
			              $m3_result->message = '注册成功！';
			              return $m3_result->toJson();
		          	  }
		          	 
		          }else{
		              $m3_result->status = 1;
		              $m3_result->message = '手机验证码有误！';
		              return $m3_result->toJson();
		          }
		      }else{
		          $m3_result->status = 1;
		          $m3_result->message = '手机验证码已过期，请重新发送！';
		          return $m3_result->toJson();
		      }

     	}else{
     		//判断验证码
     		$validate_code = $request->session()->get('validate_code');
     		if($validate_code == $vcode){
     			// 验证码通过验证;
	          	  if(Member::where('email', $email)->first()){
	          	  	  $m3_result->status = 1;
		              $m3_result->message = '此邮箱已注册！';
		              return $m3_result->toJson();
	          	  }else{
	          	  	  $member = new Member();
	          	  	  $member->email = $email;
		          	  $member->password = md5($password + 'laravel');
		          	  $member->save();
		          	 
		              	// 发送邮件
		     			$m3_email = new M3Email;
		     			$m3_email->to = $email;
		     			$m3_email->subject = "邮箱注册激活";
		     			$uuid = UUID::create();
		     			$m3_email->content = "点击激活 http://192.168.220.128:8083/service/validate_email/".$member['id'].'/'.$uuid;
		     			Mail::send('email_register', ['m3_email'=>$m3_email],function($m) use($m3_email){
		     				$m->to($m3_email->to, "收件人")
		     				  ->subject($m3_email->subject);
		     			});      

		     			$temp_email = new TempEmail();
	          	  	  	$temp_email->member_id = $member['id'];
		          	  	$temp_email->code = $uuid;
		          	  	$temp_email->deadline = date('Y-m-d H-i-s',time() + 60*60);
		          	  	$temp_email->save();
		     			$m3_result->status = 0;
			            $m3_result->message = '注册成功！请打开邮件激活后登录';
			            return $m3_result->toJson();   

	          	  }
     			
     		}else{
     			 $m3_result->status = 1;
		         $m3_result->message = '验证码不正确';
		         return $m3_result->toJson();
     		}

     	}

    }

    public function login(Request $request){
     	$phone = $request->input('phone');
     	$email = $request->input('email');
     	$password = $request->input('password');
     	$vcode = $request->input('vcode');
     	$code = $request->session()->get('validate_code');
     	$m3_result = new M3Result;

     	if($vcode == $code){
     		if($phone != ''){
     			$m = Member::where(array('phone'=>$phone))->first();
     			if($m->password == md5($password+'laravel')){
     				  $request->session()->put('user',$m);
     				  $m3_result->status = 0;
			          $m3_result->message = '登陆成功！';
			          return $m3_result->toJson();
     			}else{
     				  $m3_result->status = 1;
			          $m3_result->message = '登陆失败！';
			          return $m3_result->toJson();
     			}
     		}else{
     			$m = Member::where(array('email'=>$email))->first();
     			if($m->password == md5($password+'laravel') && $m['active']=='1'){
     				  $request->session()->put('user',$m);
     				  $m3_result->status = 0;
			          $m3_result->message = '登陆成功！';
			          return $m3_result->toJson();
     			}else{
     				  $m3_result->status = 1;
			          $m3_result->message = '登陆失败！';
			          return $m3_result->toJson();
     			}
     		}
     	}
    }


    
      
}
