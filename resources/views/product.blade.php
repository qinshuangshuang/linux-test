@extends('master')

@include('component.loading')

@section('title', '分类')

@section('content')
 
    <div class="weui_cells weui_cells_access">

        @foreach($products as $product)
            <a class="weui_cell" href="/pdtcontent/product_id/{{$product->id}}">
                <div class="weui_cell_hd"><img src="{{$product->preview}}" class="bk_preview" ></div>
                
                <div class="weui_cell_bd weui_cell_primary">
                    <span class="bk_title">{{$product->name}}</span>
                    <span class="bk_price" style="float:right">￥{{$product->price}}</span>
                    <p class="bk_summary">{{str_limit($product->summary, $limit = 100, $end = '...')}}</p>
                </div>
                <div class="weui_cell_ft">
                    
                </div>
            </a>
        @endforeach
    </div>

@endsection

@section('my-js')
<script type="text/javascript">
   
    products = "{{$products}}";
    console.log(products);
</script>
 
@endsection
