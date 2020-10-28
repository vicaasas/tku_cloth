<div class="container">
    <div class="container text-center h2">
        您好，{{ $user->student_name }} 同學
    </div>

    個人訂單
    <br>
    @if($self_order != null)
        @if($self_order->has_cancel==1)
        被取消
            {{ $self_order }}
        @else
        自己的訂單
            {{ $self_order }}
        @endif
    @endif
    <br>
    取消的訂單
    {{ $cancel_order }}
<table class="table table-sm table-striped table-hover table-condensed">
<thead>
    <tr>
    <th class="text-center align-middle">訂單編號</th>
    <th class="text-center align-middle">班級</th>
    <th class="text-center align-middle">學號</th>
    <th class="text-center align-middle">姓名</th>
    <th class="text-center align-middle">學位</th>
    <th class="text-center align-middle">尺寸</th>
    <th class="text-center align-middle">配件</th>
    <th class="text-center align-middle"><strong>操作</strong></th>
    </tr>
</thead>

<tbody>

@foreach($cancel_order as $cancel_order)
@if(!$cancel_order['this_cancels']->isEmpty())
    <tr>
        <th class="text-center align-middle">{{ $cancel_order['order_id'] }}</th>

        <th class="text-center align-middle">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#recoverorder_Modal" data-order_id="{{ $cancel_order['order_id'] }}">恢復訂單</button>
        </th>

    </tr>
    @foreach($cancel_order['this_cancels'] as $this_cancels)
        <tr>
            <th style="text-center align-middle"></th>
            <th style="text-center align-middle">{{ $this_cancels['class_name'] }}</th>
            <th style="text-center align-middle">{{ $this_cancels['student_id'] }}</th>
            <th style="text-center align-middle">{{ $this_cancels['student_name'] }}</th>
            <th style="text-center align-middle">{{ $this_cancels['type'] }}</th>
            <th style="text-center align-middle">{{ $this_cancels['size'] }}</th>
            <th style="text-center align-middle">{{ $this_cancels['color'] }}</th>
            <th style="text-center align-middle">
                <button id="edit_order" type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal" data-student_id="{{ $this_cancels['student_id'] }}" data-order_id="{{ $this_cancels['order_id'] }}">編輯</button>

                <button id="delete_order" type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteModal" data-student_id="{{ $this_cancels['student_id'] }}" data-order_id="{{ $this_cancels['order_id'] }}">刪除</button>
            </th>
        </tr>
    @endforeach
@endif

@endforeach
</tbody>
</table>
<div
  class="modal fade"
  id="recoverorder_Modal"

  role="dialog"
  aria-labelledby="recoverorderModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="recoverorderModalLabel">恢復訂單</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
        <button
          type="button"
          id="recover_bt"
          class="btn btn-primary"
          data-dismiss="modal"
        >確定</button>
      </div>
    </div>
  </div>
</div>
<script>
$('#recoverorder_Modal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var order_id = button.data('order_id') 

  console.log(order_id);
  var modal = $(this)
  modal.find('.modal-body').html('您確定要恢復訂單編號 ' + order_id+'<br>(此動作視為建立新訂單)')
  modal.find('#recover_bt').attr("data-order",order_id);

});
$('#recover_bt').click(function() {
  var order_id = $('#recover_bt').attr('data-order');

  console.log(order_id);
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  $.ajax({
    type:'POST',
    url:"{{ route('recover_order') }}",
    data:{order_id:order_id},

    success:function(data){
      //alert();
      setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
      }, 100);  
    }
  });

});
</script>
    <br>
    個人資料
    {{ $user }}
    <br>
    班級資料
    {{ $student_class_data }}
    <br>
    代訂訂單
    <br>
    {{ $student_order }}
    <br>
    剩餘衣物
    <br>
    {{ $cloth_remainder }}
    {{ json_encode(old()) }}

    <a href="{{ route('student_bill_pdf',$user->student_id) }}" target="_blank">列印繳費單</a>
    <a href="{{ route('receipt_bail') }}" target="_blank">列印保證金繳費證明</a>
    <a href="{{ route('bill_proof') }}" target="_blank">列印洗滌及折舊費繳費證明</a>

    <form action="{{ route('order.save') }}" method="post">
        @csrf
        <div class="form-group row">
        <div class="col-md-6">
            <input type="text" name="order_property[0][student_id]" placeholder="學號" value={{ old('old_order.0.student_id') }}>
            <input type="text" name="order_property[0][size]" placeholder="尺寸" value={{ old('old_order.0.size') }}>
            <input type="text" name="order_property[0][color]" placeholder="顏色" value={{ old('old_order.0.color') }}>

        </div>
                
        <div class="col-md-6">
            <input type="text" name="order_property[1][student_id]" placeholder="學號">

            <input type="text" name="order_property[1][size]" placeholder="尺寸">
            <input type="text" name="order_property[1][color]" placeholder="顏色">
        </div>
<!-- 


        
        <div class="col-md-6">
            <input type="text" name="order_property[2][student_id]" placeholder="學號">

            <input type="text" name="order_property[2][size]" placeholder="尺寸">
            <input type="text" name="order_property[2][color]" placeholder="顏色">
        </div>
        <div class="col-md-6">
            <input type="text" name="order_property[3][student_id]" placeholder="學號">

            <input type="text" name="order_property[3][size]" placeholder="尺寸">
            <input type="text" name="order_property[3][color]" placeholder="顏色">
        </div>
        <div class="col-md-6">
            <input type="text" name="order_property[4][student_id]" placeholder="學號">

            <input type="text" name="order_property[4][size]" placeholder="尺寸">
            <input type="text" name="order_property[4][color]" placeholder="顏色">
        </div>
        <div class="col-md-6">
            <input type="text" name="order_property[5][student_id]" placeholder="學號">

            <input type="text" name="order_property[5][size]" placeholder="尺寸">
            <input type="text" name="order_property[5][color]" placeholder="顏色">
        </div>
        <div class="col-md-6">
            <input type="text" name="order_property[6][student_id]" placeholder="學號">

            <input type="text" name="order_property[6][size]" placeholder="尺寸">
            <input type="text" name="order_property[6][color]" placeholder="顏色">
        </div>
        <div class="col-md-6">
            <input type="text" name="order_property[7][student_id]" placeholder="學號">

            <input type="text" name="order_property[7][size]" placeholder="尺寸">
            <input type="text" name="order_property[7][color]" placeholder="顏色">
        </div>
        <div class="col-md-6">
            <input type="text" name="order_property[8][student_id]" placeholder="學號">

            <input type="text" name="order_property[8][size]" placeholder="尺寸">
            <input type="text" name="order_property[8][color]" placeholder="顏色">
        </div>
        <div class="col-md-6">
            <input type="text" name="order_property[9][student_id]" placeholder="學號">

            <input type="text" name="order_property[9][size]" placeholder="尺寸">
            <input type="text" name="order_property[9][color]" placeholder="顏色">
        </div> -->

        </div>
        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    新增訂單
                </button>
            </div>
        </div>
    </form>
    <form action="{{ route('order.student_all_order_delete') }}" method="post">
        @csrf
        <div class="form-group row">

        <div class="col-md-6">
            <input type="text" name="order_id" placeholder="id">
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
