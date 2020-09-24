<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <p style="font-size:50px;width:100%;text-align:center;">{{ $pdf_name }}</p>
        <table cellpadding="10" border="1" style="margin:0 auto;">
            <thead>
                <tr>
                    <th style="font-size:50px">班級</th>
                    <th style="font-size:50px">學號</th>
                    <th style="font-size:50px">姓名</th>
                    <th style="font-size:50px">尺寸</th>
                    <th style="font-size:50px">領巾</th>
                    <th style="font-size:50px">帽穗、披肩</th>
                </tr>
            </thead>
            <tbody>
            @foreach($return_order_state as $return_order_state)
                <tr>
                    <th style="font-size:25px">{{ $return_order_state->class_name }}</th>
                    <th style="font-size:25px">{{ $return_order_state->student_id }}</th>
                    <th style="font-size:25px">{{ $return_order_state->student_name }}</th>
                    <th style="font-size:25px">{{ $return_order_state->size }}</th>
                    @if($return_order_state->accessory=="領巾")
                        <th style="font-size:25px">{{ $return_order_state->color }}</th>
                        <th style="font-size:25px"></th>
                    @else
                        <th style="font-size:25px"></th>
                        <th style="font-size:25px">{{ $return_order_state->color }}</th>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>

    </body>
</html>