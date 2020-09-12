<div class="container">
    <div class="container text-center h2">
        您好，{{ $user->class_name }} 系/所畢代
    </div>
    
    {{ $time[0]->content }}
    開始時間 : 
    {{ $time[0]->start_time }}
    結束時間 : 
    {{ $time[0]->end_time }}
    {{ $user }}
    {{ $remainder }}
    {{ $student_order }}
    <a href="pdf/clothes_preview.pdf">服飾瀏覽</a>
    <p>剩餘數量</p>
    <table>
    <thead>
    <tr>
        @foreach($remainder as $remainder_column)
            <td>{{ $remainder_column->property }}</td>
        @endforeach
    </tr>
    </thead>
    <tbody>
        @foreach($remainder as $remainder_value)
            <td>{{ $remainder_value->remainder }}</td>
        @endforeach
    </tbody>
    </table>
    <p>班級訂單</p>
    @foreach($student_order as $student_order)
    {{ $student_order->student_id }}
    @endforeach
    <form action="{{ route('order.save') }}" method="post">
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

</div>
