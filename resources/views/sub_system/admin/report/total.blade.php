@extends('sub_system.layouts.base')
@section('title', '總表清單')
@section('content')
<select onchange="change_degree(this)">
<option value="學士">學士</option>
<option value="碩士">碩士</option>
</select>
<table class="table table-sm table-striped table-hover table-condensed" id="cloth_table">
    {!! $all_cloth_table !!}
</table>

    <!--div>
    <h1 style="display:inline-block">123</h1>
    <span style="font-size:50px">999</span>
    </div-->
    <script>
        function change_degree(degree){
            //alert(degree.value);
            //window.location = "{{ route('report.total') }}/"+degree.value;
            
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                type:'post',
                url:"{{ route('sub_system.report.change_degree') }}",
                data:{degree:degree.value},

                success:function(data){
                    //$("#column_name").html(data.column_name);
                    $("#cloth_table").html(data.all_cloth_table);
                }
            });
        }
    </script>
@endsection
