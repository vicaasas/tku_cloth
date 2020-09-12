<div class="container">
    <div class="container text-center h2">
        您好，{{ $user->department_name }} 系/所助教
    </div>
    
    {{ $time[0]->content }}
    開始時間 : 
    {{ $time[0]->start_time }}
    結束時間 : 
    {{ $time[0]->end_time }}
    {{ $user }}
    {{ $class }}
    @if(isset($student))
        {{ $student }}
    @endif
    @foreach($class as $class)
        <a href="{{ route('department.page') }}/{{ $class->class_name }}" id='{{ $class->class_id }}'>{{ $class->class_name }}</a>
    @endforeach
    @if(isset($this_class))
        <form action="{{ route('order.save') }}/{{ $this_class->m_or_b }}" method="post">
            @csrf
            <div class="form-group row">
                <div class="col-md-6">
                    <input id="location" type="text" name="student_id" placeholder="學號">
                    <input id="location" type="text" name="student_name" placeholder="名字">
                </div>
                
                <div class="col-md-6">
                    <input id="location" type="text" name="size" placeholder="衣服尺寸">
                    <input id="location" type="text" name="accessory" placeholder="配件顏色">
                </div>
    
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        新增訂單
                    </button>
                </div>
            </div>
        </form>
    
    @endif

    <a href="pdf/clothes_preview.pdf">服飾瀏覽</a>
    <!--script type="text/javascript">

        function get_class_data(now_class){
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
            type:'POST',
            url:"{{ route('department.return_class') }}",
            data:{class_id:now_class.id},

            success:function(data){
                    //alert(data.student_order[0].student_id);
                    $("#show").html(data.order_table);
            }
            });
        }
    </script-->
</div>
