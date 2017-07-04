@extends('master')

@include('component.loading')

@section('title', $product->name)

@section('content')
<link rel="stylesheet" href="/css/swiper-3.4.2.min.css">

<div class="page article">
    <div class="hd">
        <h1 class="page_title">Article</h1>
        <div class="swiper-container">
        <!-- 轮播图 -->
        <div class="swiper-wrapper">
        @foreach($product['images'] as $image)
            <div class="swiper-slide"><img src="{{$image['image_path']}}" width="500px"></div>
        @endforeach
        </div>



    </div>
    <div class="bd">
        <article class="weui_article">
            <h1>{{$product->name}}</h1>
            <section>
                
                <section>
                    <p> {{$product->content or ''}} </p>
                </section>
            </section>
        </article>
    </div>
</div>



<a href="javascript:;" id="addCart" class="weui_btn weui_btn weui_btn_primary">加入购物车</a>
<a href="javascript:;" class="weui_btn weui_btn weui_btn_default">结算(<span id="num">{{$product->num}}</span>)</a>
                
@endsection

@section('my-js')
<script type="text/javascript" src="/js/swiper-3.4.2.jquery.min.js"></script>
<script type="text/javascript">
   
    product = "{{$product}}";
    console.log(product);
    // images = "{{$product->images}}";
    // console.log(images);

    var mySwiper = new Swiper('.swiper-container', {
        autoplay: 1000,//可选选项，自动滑动
        autoHeight: true
    });


    $('#addCart').click(function(){
        product_id = "{{$product->id}}";
        $.ajax({
            url: '/addCart/product_id/'+product_id,
            method: 'get',
            dataType:'json',
            data: {},
            success: function(data) {
                console.log(data);
                if(data.status == 0 ){
                    num = $('#num').html();
                    $('#num').html(Number(num)+1);
                }
            }
        });        
    });
    
</script>
@endsection
