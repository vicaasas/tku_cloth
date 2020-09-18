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
    <th class="text-center align-middle">歸還</th>
    </tr>
</thead>
<tbody>
@foreach($student_order as $student_order)

    <tr>
        <th style="text-center align-middle">{{ $student_order->order_id }}</th>
        <th style="text-center align-middle">{{ $student_order->class_name }}</th>
        <th style="text-center align-middle">{{ $student_order->student_id }}</th>
        <th style="text-center align-middle">{{ $student_order->student_name }}</th>
        <th style="text-center align-middle">{{ $student_order->type }}</th>
        <th style="text-center align-middle">{{ $student_order->size }}</th>
        <th style="text-center align-middle">{{ $student_order->color }}</th>
        <th style="text-center align-middle">
            <button id="return_this_order" type="button" class="btn btn-primary" data-toggle="modal" data-target="#returnModal" data-student_id="{{ $student_order->student_id }}" data-order_id="{{ $student_order->order_id }}">歸還</button>
        </th>
    </tr>

@endforeach
</tbody>
</table>

<div
  class="modal fade"
  id="returnModal"

  role="dialog"
  aria-labelledby="returnModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">歸還訂單</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
        <button
          type="button"
          id="return"
          class="btn btn-primary"
          data-dismiss="modal"
        >確定</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<script>

$(document).on('show.bs.modal','#returnModal', function (event) {

  var button = $(event.relatedTarget)
  var order_id = button.data('order_id') 
  var student_id = button.data('student_id') 
  console.log(order_id);
  var modal = $(this)
  modal.find('.modal-body').text('您確定要歸還訂單編號' + order_id+"?")
  modal.find('#return').attr("data-order",order_id);
  modal.find('#return').attr("data-student_id",student_id);
});

$('#return').click(function() {
  var order_id = $('#return').attr('data-order');
  var student_id = $('#return').attr('data-student_id');
  console.log(order_id);
  console.log(student_id);
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  $.ajax({
    type:'POST',
    url:"{{ route('return_order') }}",
    data:{order_id:order_id,student_id:student_id},

    success:function(data){
            //alert(data.student_order[0].student_id);
      $("#return_this_order").attr("disabled", true);
      setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
      }, 500);  
    }
  });
});
</script>
