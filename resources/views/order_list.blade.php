@extends('master')

@include('component.loading')

@section('title', 'order_pay')

@section('content')
 
    <div class="weui_cells">

        <div class="weui_cells weui_cells_checkbox">
            @foreach($order_list as $order)
               
                <div class="weui_cell">
                    <div class=" weui_cell_primary">
                        <p>订单号:{{$order->order_no}}</p>
                    </div>
                    <div class="weui_cell_ft">
                        <p>
                            @if ($order->status == 1)
                                已支付
                            @else
                                未支付
                            @endif
                        </p>
                    </div>
                </div>
                 
                @foreach($order->orderItem as $cart)

                    <label class="weui_cell weui_check_label" for="{{$cart->id}}">
                        <div class="weui_cell_hd">
                            <input type="checkbox" class="weui_check" name="toBuy" id="{{$cart->id}}" checked="checked">
                            <i class="weui_icon_checked"></i>
                        </div>
                        <div class="weui_cell_bd weui_cell_primary">
                            <a class="weui_cell" href="/pdtcontent/cart_id/{{$cart->id}}">
                                <div class="weui_cell_hd"><img src="{{$cart->product->preview}}" class="bk_preview" ></div>
                                
                                <div class="weui_cell_bd weui_cell_primary">
                                    <span class="bk_title">{{$cart->product->name}}</span>
                                    <span class="bk_price" style="float:right">￥{{$cart->product->price}} RMB X {{$cart->count}}</span>
                                    <p class="bk_summary">{{str_limit($cart->product->summary, $limit = 100, $end = '...')}}</p>
                                </div>
                                <div class="weui_cell_ft">
                                    
                                </div>
                            </a>
                        </div>
                    </label>
                 
               
                @endforeach
                <div class="weui_cells weui_cells_split">
                    <div class="weui_cell">
                        <div class="weui_cell_bd weui_cell_primary">
                            <p>共计：{{$order->total_count}}件</p>
                        </div>
                        <div class="weui_cell_ft">
                           合计： ￥{{$order->total_price}}元
                        </div>
                    </div>
                   
                </div>
            @endforeach
        </div>
    </div>

<a href="javascript:;" id="toCommit" class="weui_btn weui_btn weui_btn_primary">提交订单</a>
<a href="javascript:;" id="pdtDel" class="weui_btn weui_btn weui_btn_default">取消</a>
       
@endsection 

@section('my-js')
<script type="text/javascript">
   
    $('#toCommit').click(function(){
        var ids = '';
        $("input[name=toBuy]:checked").each(function(){
            id = $(this).attr("id");
            alert(id);
            ids += id+',';
        });
        ids = ids.substring(0, ids.length-1);

        console.log(ids);
        alert('ids=='+ids);

        location.href = '/order_commit/'+ids;
        
    });



</script>
 
@endsection
