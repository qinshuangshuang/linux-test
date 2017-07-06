@extends('master')

@include('component.loading')

@section('title', 'order_pay')

@section('content')
 
    <div class="weui_cells weui_cells_access">

        <div class="weui_cells weui_cells_checkbox">
            @foreach($carts as $cart)
                <label class="weui_cell weui_check_label" for="{{$cart->id}}">
                
                    <div class="weui_cell_bd weui_cell_primary">
                        <a class="weui_cell" href="/pdtcontent/cart_id/{{$cart->id}}">
                            <div class="weui_cell_hd"><img src="{{$cart->product->preview}}" class="bk_preview" style="width:40px; height:40px"></div>
                            
                            <div class="weui_cell_bd weui_cell_primary">
                                <span class="bk_title">{{$cart->product->name}}</span>
                                <span class="bk_price" style="float:right">￥{{$cart->product->price}} RMB X {{$cart->count}}</span>
                            </div>
                            <div class="weui_cell_ft">
                                
                            </div>
                        </a>
                    </div>
                </label>
                 
               
            @endforeach
        </div>
    </div>

    <div class="weui_cells_title">选择支付方式</div>
    <div class="weui_cells weui_cells_split">
        <div class="weui_cell weui_cell_select">
            <div class="weui_cell_bd weui_cell_primary">
                <select class="weui_select" name="payType">
                    <option selected="" value="1">微信</option>
                    <option value="2">支付宝</option>
                </select>
            </div>
        </div>
       
    </div>
    <div class="weui_cells weui_cells_split">
        <div class="weui_cell">
            <div class="weui_cell_bd weui_cell_primary">
                <p>金额总计</p>
            </div>
            <div class="weui_cell_ft">
                ￥{{$total_price}}元
            </div>
        </div>
       
    </div>

     <div class="weui_cells weui_cells_split">
            <a href="" id="toCommit" class="weui_btn weui_btn weui_btn_primary">支付</a>
            <a href="javascript:;" id="pdtDel" class="weui_btn weui_btn weui_btn_default">取消</a>
    </div>
       

@endsection 

@section('my-js')
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script type="text/javascript">
    wx.config({
        debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: '', // 必填，公众号的唯一标识
        timestamp: , // 必填，生成签名的时间戳
        nonceStr: '', // 必填，生成签名的随机串
        signature: '',// 必填，签名，见附录1
        jsApiList: ['chooseWXPay'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
    });
    wx.ready(function(){
      
    });

</script>

<script type="text/javascript">
   
    $('#toCommit').click(function(){
        type = $('select[name=payType]').val();
        if( type == 1 ){
            //微信

        }else{
            //支付宝
            $.ajax({
                url: '/alipay',
                method: 'post',
                dataType:'json',
                data: {_token:"{{csrf_token()}}"},
                success: function(data) {
                    console.log(data);
                    
                }
            });    
        }

    });


</script>
 
@endsection
