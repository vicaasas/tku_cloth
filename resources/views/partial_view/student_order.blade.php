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
@foreach($student_order as $student_order)
  @if(!$student_order['have_orders']->isEmpty())
    <tr>
        <th class="text-center align-middle">{{ $student_order['order_id'] }}</th>
     
          @if($student_order->has_paid==0)
            <th class="text-center align-middle">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#inputreceipt_Modal" data-order_id="{{ $student_order['order_id'] }}">繳費收據登記</button>
                <a href="{{ route('print.student_bill_pdf',['student_id'=>$student_order['stu_id'],'order_id'=>$student_order['order_id']]) }}" target="_blank">列印繳費單</a>
            </th>
          @else
            <th class="text-center align-middle">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#inputreceipt_Modal" data-order_id="{{ $student_order['order_id'] }}" disabled>繳費已登記</button>
                <a href="{{ route('print.student_bill_pdf',['student_id'=>$student_order['stu_id'],'order_id'=>$student_order['order_id']]) }}" target="_blank">列印繳費單</a>

            </th>
          @endif

    </tr>
    @foreach($student_order['have_orders'] as $have_orders)
        <tr>
            <th style="text-center align-middle"></th>
            <th style="text-center align-middle">{{ $have_orders['class_name'] }}</th>
            <th style="text-center align-middle">{{ $have_orders['student_id'] }}</th>
            <th style="text-center align-middle">{{ $have_orders['student_name'] }}</th>
            <th style="text-center align-middle">{{ $have_orders['type'] }}</th>
            <th style="text-center align-middle">{{ $have_orders['size'] }}</th>
            <th style="text-center align-middle">{{ $have_orders['color'] }}</th>
            <th style="text-center align-middle">
            @if($student_order->has_paid==0)
            <button id="edit_order" type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal" data-student_id="{{ $have_orders['student_id'] }}" data-order_id="{{ $student_order['order_id'] }}">編輯</button>

            <button id="delete_order" type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteModal" data-student_id="{{ $have_orders['student_id'] }}" data-order_id="{{ $student_order['order_id'] }}">取消</button>
            @else
            <button id="edit_order" type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal" data-student_id="{{ $have_orders['student_id'] }}" data-order_id="{{ $student_order['order_id'] }}" disabled>編輯</button>

            <button id="delete_order" type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteModal" data-student_id="{{ $have_orders['student_id'] }}" data-order_id="{{ $student_order['order_id'] }}" disabled>取消</button>
            @endif
          </th>
        </tr>
    @endforeach
    <tr>
    <th style="text-center align-middle"></th>
    <th style="text-center align-middle"></th>
    <th style="text-center align-middle"></th>
    <th style="text-center align-middle"></th>
    <th style="text-center align-middle"></th>
    <th style="text-center align-middle"></th>
    <th style="text-center align-middle"></th>
    @if($student_order->m_or_b=="學士")
      <th style="text-center align-middle">共計 : {{ $student_order->get_counts[0]->total * 600 }} 元</th>
    @else
      <th style="text-center align-middle">共計 : {{ $student_order->get_counts[0]->total * 1200 }} 元</th>
    @endif
    </tr>
  @endif
@endforeach
</tbody>
</table>

<div class="modal fade" id="inputreceipt_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">收據登記</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('print.get_receipt') }}" method="post">
        @csrf
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">收據單號:</label>
            <input type="text" class="form-control" id="recipient_id" name="recipient_id">
          </div>
          <div class="form-group">
            <label for="order_id" class="col-form-label">訂單編號:</label>
            <input type="text" class="form-control" id="order_id" name="order_id" readonly>
          </div>
          <div class="form-group">
            <label for="student_id" class="col-form-label">學號:</label>
            <input type="text" class="form-control" id="student_id" name="student_id">
          </div>
          <div class="form-group">
            <label for="recipient_date" class="col-form-label">收據時間:</label>
            <input type="datetime-local" class="form-control" id="recipient_date" name="recipient_date">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
            <button type="submit" class="btn btn-primary">確定</button>
        </div>
        </form>
      </div>

    </div>
  </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">編輯訂單</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('return.edit_order') }}" method="post">
        @csrf

          <div class="form-group">
            <label for="order_id" class="col-form-label">訂單編號:</label>
            <input type="text" class="form-control" id="order_id" name="order_id" readonly>
          </div>
          <div class="form-group">
            <label for="student_id" class="col-form-label">學號:</label>
            <input type="text" class="form-control" id="student_id" name="student_id">
          </div>
          <div class="form-group">
            <label for="size" class="col-form-label">尺寸:</label>
            <input type="text" class="form-control" id="size" name="size">
          </div>
          <div class="form-group">
            <label for="color" class="col-form-label">顏色:</label>
            <input type="text" class="form-control" id="color" name="color">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
            <button type="submit" class="btn btn-primary">確定</button>
        </div>
        </form>
      </div>

    </div>
  </div>
</div>
<div
  class="modal fade"
  id="deleteModal"

  role="dialog"
  aria-labelledby="deleteModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">刪除訂單</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
        <button
          type="button"
          id="delete_bt"
          class="btn btn-primary"
          data-dismiss="modal"
        >確定</button>
      </div>
    </div>
  </div>
</div>

<script>
$('#inputreceipt_Modal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var order_id = button.data('order_id')
  var modal = $(this)
  modal.find('#order_id').val(order_id)
});
$('#editModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var order_id = button.data('order_id')
  var student_id = button.data('student_id')
  console.log(button)
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('#order_id').val(order_id)
  modal.find('#student_id').val(student_id)
});
$('#deleteModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var order_id = button.data('order_id') 
  var student_id = button.data('student_id')
  console.log(order_id);
  var modal = $(this)
  modal.find('.modal-body').text('您確定要刪除訂單編號 ' + order_id+' 中 '+student_id+' 的訂單')
  modal.find('#delete_bt').attr("data-order",order_id);
  modal.find('#delete_bt').attr("data-student_id",student_id);
});
$('#delete_bt').click(function() {
  var order_id = $('#delete_bt').attr('data-order');
  var student_id = $('#delete_bt').attr('data-student_id');
  console.log(order_id);
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  $.ajax({
    type:'POST',
    url:"{{ route('return.delete_order') }}",
    data:{order_id:order_id,student_id:student_id},

    success:function(data){
      //alert();
      setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
      }, 100);  
    }
  });

});
</script>
