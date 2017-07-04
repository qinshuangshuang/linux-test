@extends('master')

@include('component.loading')

@section('title', '分类')

@section('content')
 
    <div class="weui_cells weui_cells_access">

        <div class="weui_cells weui_cells_checkbox">
        @foreach($carts as $cart)
            <label class="weui_cell weui_check_label" for="{{$cart->id}}">
                <div class="weui_cell_hd">
                    <input type="checkbox" class="weui_check" name="toBuy" id="{{$cart->id}}" checked="checked">
                    <i class="weui_icon_checked"></i>
                </div>
                <div class="weui_cell_bd weui_cell_primary">
                    <a class="weui_cell" href="/pdtcontent/cart_id/{{$cart->id}}">
                        <div class="weui_cell_hd"><img src="{{$cart->preview}}" class="bk_preview" ></div>
                        
                        <div class="weui_cell_bd weui_cell_primary">
                            <span class="bk_title">{{$cart->name}}</span>
                            <span class="bk_price" style="float:right">￥{{$cart->price}} RMB X {{$cart->num}}</span>
                            <p class="bk_summary">{{str_limit($cart->summary, $limit = 100, $end = '...')}}</p>
                        </div>
                        <div class="weui_cell_ft">
                            
                        </div>
                    </a>
                </div>
            </label>
             
           
        @endforeach
        </div>
    </div>

<a href="javascript:;" id="addCart" class="weui_btn weui_btn weui_btn_primary">结算</a>
<a href="javascript:;" id="pdtDel" class="weui_btn weui_btn weui_btn_default">删除</a>
       
@endsection 

@section('my-js')
<script type="text/javascript">
    $('#pdtDel').click(function(){
        var ids = '';
        $("input[name=toBuy]:checked").each(function(){
            id = $(this).attr("id");
            ids += id+',';
        });
        ids = ids.substring(0, ids.length-1);
        
        
    });
    
</script>
 
@endsection
