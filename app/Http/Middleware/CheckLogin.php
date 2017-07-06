<?php

namespace App\Http\Middleware;
use Closure;

class CheckLogin 
{
    public function handle($request, Closure $next){
    	$member = $request->session()->get('member', '');
        // $return_url = $request->input('return_url');
        if( isset($_SERVER['HTTP_REFERER']) ){
	    	$return_url = $_SERVER['HTTP_REFERER'];
    	}else{
    		$return_url = '';
    	}
    	if($member == ''){
    		return redirect('/login?return_url='. urlencode($return_url) );
    	}
    	return $next($request);
    }
    
}
