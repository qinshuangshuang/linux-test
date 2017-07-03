@extends('master')

@section('title', '注册')

@section('content')

	<div class="weui_cells weui_cells_form">
		<div class="weui_cells_title">选择注册方式</div>
		<div class="weui_cells weui_cells_radio">
            <label class="weui_cell weui_check_label" for="x11">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>手机号</p>
                </div>
                <div class="weui_cell_ft">
                    <input type="radio" name="register_type" class="weui_check" id="x11" value="phone">
                    <span class="weui_icon_checked"></span>
                </div>
            </label>
          
            </label>
                <label class="weui_cell weui_check_label" for="x12">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>邮箱</p>
                </div>
                <div class="weui_cell_ft">
                    <input type="radio" name="register_type" class="weui_check" id="x12" value="email">
                    <span class="weui_icon_checked"></span>
                </div>
            </label>
        </div>
    </div>

    <!-- 手机号 -->
    <div class="weui_cells weui_cells_form_phone" >
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">手机号</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="number" name="phone" placeholder="请输入手机号">
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">密码</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="password" name="password_p" placeholder="请输入6-12位的密码">
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">确认密码</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="password" name="re_password_p" placeholder="请输入确认密码">
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">手机验证码</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="number" name="pcode" placeholder="请输入手机验证码">
            </div>
            <p class="bk_important bk_phone_code_send">发送验证码</p>
            <div class="weui_cell_ft">
            </div>
        </div>

    </div>  

     <!-- 邮箱 -->
    <div class="weui_cells weui_cells_form_email" style="display: none;">
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">邮箱</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="email" name="email" placeholder="请输入邮箱">
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">密码</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="password" name="password_e" placeholder="请输入6-12位的密码">
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">确认密码</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="password" name="re_password_e" placeholder="请输入确认密码">
            </div>
        </div>
        
        <div class="weui_cell weui_vcode">
            <div class="weui_cell_hd"><label class="weui_label">验证码</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="" name="vcode" placeholder="请输入验证码">
            </div>
            <div class="weui_cell_ft">
                <img src="service/validate_code/create" id="vcode">
            </div>
        </div>

       
    </div>   


  	<div class="weui_btn_area">
        <a class="weui_btn weui_btn_primary" href="javascript:" id="register">注册</a>
    </div>

	<a href="/login" class="bk_bottom_tips bk_important">已注册? 去登录</a>            
  

@endsection

@section('my-js')
<script type="text/javascript">
	// // 默认显示手机号注册
	$('#x12').next().hide();

	$('input:radio[name=register_type]').click(function(){
		$('input:radio[name=register_type]').attr('checked', false);
		$(this).attr('checked', true);
		if($(this).attr('id') == 'x11'){
			//选择手机号
			$('#x11').next().show();
			$('#x12').next().hide();
			$('.weui_cells_form_phone').show();
			$('.weui_cells_form_email').hide();
			
		}else{
			$('#x11').next().hide();
			$('#x12').next().show();
			$('.weui_cells_form_phone').hide();
			$('.weui_cells_form_email').show();
		
		}
	});
	 

	// 点击验证码切换
	$('#vcode').click(function(){
		$(this).attr('src', 'service/validate_code/create?random=' + Math.random());
	});



	function varifyPhone(phone, password, re_password, pcode){
			//手机号
			if( $.trim(phone) == ''){
				show_toptips('手机号不能为空！');
				return ;
			}else if( phone.length != 11){
				show_toptips('手机号格式有误，应为11位数字！');
				return ;
			}else if( isNaN(phone) || (phone.indexOf('.')>=0)) {
				show_toptips('手机号格式有误，应为数字！');
				return ;
			}else if( !/^1[34578]\d{9}$/.test(phone) ){
 				show_toptips('手机号格式有误，请检查！');
 				return ;
 			}else{}
 			//密码
			if( $.trim(password) == ''){
				show_toptips('密码不能为空！');
				return ;
			}else if(password.length<6 || password.length>12){
				show_toptips('密码长度应该为6-12位！');
				return ;
			}else{}
			if( password != re_password ){
				show_toptips('两次输入密码不一致！');
				return ;
			}
			//手机验证码
 			if( $.trim(pcode) == ''){
				show_toptips('手机验证码不能为空！');
				return ;
			}else if( pcode.length != 6){
				show_toptips('手机验证码格式有误，应为6位数字！');
				return ;
			}else if( isNaN(pcode) || (pcode.indexOf('.')>=0)) {
				show_toptips('手机验证码格式有误，应为6位数字！');
				return ;
			}else{}
	}
	

	function varifyEmail(email, password, re_password, vcode){
		//邮箱
		var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/; 
		if( $.trim(email) == ''){
			show_toptips('邮箱不能为空！');
			return ;
		}else if( !reg.test(email) ){
			show_toptips('邮箱格式有误，请检查！');
			return ;
		}else{}
			//密码
		if( $.trim(password) == ''){
			show_toptips('密码不能为空！');
			return ;
		}else if(password.length<6 || password.length>12){
			show_toptips('密码长度应该为6-12位！');
			return ;
		}else{}
		if( password != re_password ){
			show_toptips('两次输入密码不一致！');
			return ;
		}
		//验证码
		if( $.trim(vcode) == ''){
			show_toptips('验证码不能为空！');
			return ;
		}else if( vcode.length != 4){
			show_toptips('验证码格式有误，应为4位！');
			return ;
		}else{}
	}

	// 发送手机验证码
	var enable_code = true;
	$('.bk_phone_code_send').click(function(){
		// 发送验证码前，先验证格式
		phone = $('input[name=phone]').val();
		// 手机号不为空
	    if(phone == '') {
	      show_toptips('手机号不能为空！');
		  return ;
	    }
	    // 手机号格式
	    if(  !/^1[34578]\d{9}$/.test(phone) ) {
	    	show_toptips('手机格式不正确');
		  	return ;
	    }


		if(enable_code){
			$(this).removeClass('bk_important');
	    	$(this).addClass('bk_summary');
			var num = 5;
			var interval = window.setInterval(function(){
				num--;
				$('.bk_phone_code_send').html(num+'秒后重新发送');
				if(num == 0){
					$('.bk_phone_code_send').html('发送验证码');
					window.clearInterval(interval);
				}
			}, 1000);
		}
		enable_code = false;


		$.ajax({
		        url: '/service/validate_phone/send/'+phone,
		        dataType: 'json',
		        cache: false,
		        data: {},
		        success: function(data) {
        		   console.log(data);
        		   if( data.status!=0 ){
        		   		show_toptips('手机验证码发送失败！');
		  				return ;
        		   }
		        }
		});      
	});
	

	// 点击提交时前端验证
	$('#register').click(function(){
		$('input:radio[name=register_type]').each(function(index, el) {

			if($(this).attr('checked') == 'checked') {
				if( $(this).attr('id') == 'x11' ){
					var phone = $('input[name=phone]').val();
					var password = $('input[name=password_p]').val();
					var re_password = $('input[name=re_password_p]').val();
					var pcode = $('input[name=pcode]').val();
					varifyPhone(phone, password, re_password, pcode);

				}else{
					var email = $('input[name=email]').val();
					var password = $('input[name=password_e]').val();
					var re_password = $('input[name=re_password_e]').val();
					var vcode = $('input[name=vcode]').val();
					if( varifyEmail(email, password, re_password, vcode) == false ){
						return ;
					}
				}
				$.ajax({
			        url: '/service/register',
			        method: 'post',
			        dataType:'json',
			        data: {phone:phone,email:email, pcode:pcode, vcode:vcode, password:password, re_password:re_password, _token:"{{csrf_token()}}"},
			        success: function(data) {
		        		show_toptips( data.message );
		        		if(data.status == 0){
		  					window.setTimeout(function(){
		  						window.location.href = "/login";
		  					}, 2000);  
		        		}else{
		        			window.setTimeout(function(){
		  						window.location.href = "/register";
		  					}, 2000); 
		        		}
			        }
			    });    

			}
		});
	});

	

	



</script>

@endsection
