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
    
    </tr>
</thead>
<tbody>
@foreach($student_order as $student_order)
    <tr>
        <th class="text-center align-middle">{{ $student_order['order_id'] }}</th>
        
        <th class="text-center align-middle">
        @if($student_order->has_get_cloths==0)
          <button id="get_this_cloths" type="button" class="btn btn-primary" data-toggle="modal" data-target="#getclothsModal" data-order_id="{{ $student_order['order_id'] }}">領取</button>
        @else
          <button id="get_this_cloths" type="button" class="btn btn-primary" data-toggle="modal" data-target="#getclothsModal" data-order_id="{{ $student_order['order_id'] }}" disabled>領取</button>
        @endif
        </th>
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
        </tr>
    @endforeach
@endforeach
</tbody>
</table>
<div
  class="modal fade"
  id="getclothsModal"

  role="dialog"
  aria-labelledby="getclothsModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="getclothsModalLabel">領取訂單</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
        <button
          type="button"
          id="get_cloth"
          class="btn btn-primary"
          data-dismiss="modal"
        >確定</button>
      </div>
    </div>
  </div>
</div>

<script>

$(document).on('show.bs.modal','#getclothsModal', function (event) {

  var button = $(event.relatedTarget)
  var order_id = button.data('order_id') 
  console.log(order_id);
  var modal = $(this)
  modal.find('.modal-body').text('要領取訂單編號' + order_id+"?")
  modal.find('#get_cloth').attr("data-order",order_id);
});

$('#get_cloth').click(function() {
  var order_id = $('#get_cloth').attr('data-order');

  console.log(order_id);
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  $.ajax({
    type:'POST',
    url:"{{ route('is_get_cloths') }}",
    data:{order_id:order_id},

    success:function(data){
            //alert(data.student_order[0].student_id);
      //$("#get_this_cloths").attr("disabled", true);
      setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
      }, 100);  
    }
  });
});
</script>