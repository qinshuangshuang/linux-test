@extends('master')

@include('component.loading')

@section('title', '登录')

@section('content')
 
		<div class="weui_cells weui_cells_form">
            <div class="weui_cell">
                <div class="weui_cell_hd"><label class="weui_label">账号</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" type="text" name="username" placeholder="请输入手机号或邮箱">
                </div>
            </div>
            <div class="weui_cell">
                <div class="weui_cell_hd"><label class="weui_label">密码</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" type="password" name="password" placeholder="请输入密码">
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
            <a class="weui_btn weui_btn_primary" href="javascript:" id="login">登录</a>
        </div>

		<a href="/register" class="bk_bottom_tips bk_important">没有帐号? 去注册</a>            


        


@endsection

@section('my-js')
<script type="text/javascript">


	$('#vcode').click(function(){
		$(this).attr('src', 'service/validate_code/create?random'+ Math.random());
	});

    $('#login').click(function(){
        //前端验证
        //提交登录
        username = $('input[name=username]').val();
        password = $('input[name=password]').val();
        vcode = $('input[name=vcode]').val();
        

        if(username.indexOf('@')>0 ){
            email = username;
            phone = '';
        }else{
            phone = username;
            email = '';
        }
        $.ajax({
            url: '/service/login',
            method: 'post',
            dataType:'json',
            data: {phone:phone,email:email, vcode:vcode, password:password, _token:"{{csrf_token()}}"},
            success: function(data) {
                show_toptips( data.message );
                if(data.status ==0 ){
                    window.location.href = "category";
                }
            }
        });    
    });
</script>
 
@endsection
