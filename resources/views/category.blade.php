@extends('master')

@include('component.loading')

@section('title', '分类')

@section('content')
 
		<div class="weui_cells weui_cells_split">
            <div class="weui_cell weui_cell_select">
                <div class="weui_cell_bd weui_cell_primary">
                    <select class="weui_select" name="select1">
                        <!-- <option selected="" value="1">微信号</option>
                        <option value="3">Email</option> -->
                        @foreach($categorys as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>

                        @endforeach
                    </select>
                </div>
            </div>
            
            

        </div>
        <div class="child weui_cells weui_cells_access">
           <!--  <a class="weui_cell" href="javascript:;">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>cell standard</p>
                </div>
            </a> -->
        </div>
      


@endsection

@section('my-js')
<script type="text/javascript">
   
   function get_cat(){
        parent_id = $('select[name=select1]').val();
        $.ajax({
            url: '/getCategory',
            method: 'post',
            dataType:'json',
            data: {parent_id:parent_id, _token:"{{csrf_token()}}"},
            success: function(data) {
                if(data.status == 0 ){
                    $('.child').html('');
                    for (var i = 0; i < data.categorys.length; i++) {
                        category = data.categorys[i];
                        content = 
                         '<a class="weui_cell" href="product/category_id/'+category["id"]+'">'+
                            '<div class="weui_cell_bd weui_cell_primary">'+
                                '<p>'+category["name"]+'</p>'+
                            '</div>'+
                        '</a>';
                        $('.child').append(content);
                    };
                }else{
                    show_toptips( data.message );
                }

            },
            error:function(xhr, status, error){

            }
        });    
   }
      
    categorys = "{{$categorys}}";
    get_cat();
    $('select[name=select1]').change(function(){
        get_cat();
    });
    
</script>
 
@endsection
