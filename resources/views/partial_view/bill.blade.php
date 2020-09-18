<html>
    <head>
        <meta http-equiv=Content-Type content="text/html; charset=UTF-8">

    </head>
<body>

<div style="width:100%;font-family:標楷體;font-size:30px">
    @foreach($bill_receipt as $bill_receipt)
        <div style="height:500px">
            <div>
                <div style="font-size:60px;text-align:center;font-family:標楷體;margin-left:3%;"><strong>淡江大學畢業班級{{ $student_data->m_or_b }}服借用預約訂單</strong></div>
            </div>
            <div>訂購人 : {{ $student_data->student_id }} {{ $student_data->student_name }}</div>
            <table style="font-size:30px;">
            @foreach($student_order->have_orders as  $have_orders)
            <tr>
        
                <td>{{ $have_orders->student_id }}</td>
                <td>{{ $have_orders->student_name }}</td>

            </tr>
            @endforeach
            </table>
            <div>
            <table style="font-size:27px;text-align:left;" width="1250">
                <tr>
                    <th width="120" valign="top">備註：</th>
                    <th>
                        <ol style="line-height:30px;">
                            <li>
                                請持本單至守謙會議中心HC308事務整備組領取粘存單後，<br>
                                至商管大樓B304出納組繳費，並加蓋出納組收費章方為有效。<br>
                                事務整備組收執聯須交回事務整備組存查。
                            </li>
                            <li style="margin-top:10px">
                                繳費期限為
                                    {{ date("Y/m/d", strtotime($payment_time->start_time)) }}
                                    至
                                    {{ date("Y/m/d", strtotime($payment_time->end_time)) }}
                                止，逾期視為放棄租借。
                            </li>
                            <li style="margin-top:10px">
                                請於
                                {{ date("Y/m/d", strtotime($cloth_pick_time->start_time)) }}
                                至
                                {{ date("Y/m/d", strtotime($cloth_pick_time->end_time)) }}
                                下午2時至4時，持本繳費單繳款人收執聯至覺生紀念圖書館大門前領取學士服。<br>
                            </li>
                        </ol>
                    </th>
                </tr>
            </table>
            </div>
        </div>
        <div style="text-align:right;">{{ $bill_receipt }}</div>
        <hr style="border:2px black dashed;">
    @endforeach
    <div style="height:500px">
        <div>
            <div style="font-size:60px;text-align:center;font-family:標楷體;margin-left:3%;">
                <strong>淡江大學畢業班級{{ $student_data->m_or_b }}服借用預約訂單</strong>
            </div>
            <div>
                訂購人 : {{ $student_data->student_id }} {{ $student_data->student_name }}
                <span style="margin-left:50px;"><img src="" style="height:70px;width:550px"></span>
            </div>
            <!-- <img src="http://163.13.178.165/examples.php?barcode={{ $student_data->student_id }}" style="height:70px;width:550px"> -->
            <div>
                <table style="font-size:30px;">
                    @foreach($student_order->have_orders as  $have_orders)
                        <tr>
                    
                            <td>{{ $have_orders->student_id }}</td>
                            <td>{{ $have_orders->student_name }}</td>
                            <td>{{ $have_orders->type }}{{ $have_orders->cloth }}{{ $have_orders->size }}</td>
                            <td>{{ $have_orders->accessory }}{{ $have_orders->color }}色</td>
                        </tr>
                    @endforeach
                </table>
                <div>事務組經辦人 : {{ $admin->name }}</div>
                    <table style="font-size:27px;text-align:left;" width="1250">
                        <tr>
                            <th width="120" valign="top">備註：</th>
                            <th>
                                <ol style="line-height:30px;">
                                    <li>
                                        請持本單至守謙會議中心HC308事務整備組領取粘存單後，<br>
                                        至商管大樓B304出納組繳費，並加蓋出納組收費章方為有效。<br>
                                        事務整備組收執聯須交回事務整備組存查。
                                    </li>
                                    <li style="margin-top:10px">
                                        繳費期限為
                                            {{ date("Y/m/d", strtotime($payment_time->start_time)) }}
                                            至
                                            {{ date("Y/m/d", strtotime($payment_time->end_time)) }}
                                        止，逾期視為放棄租借。
                                    </li>
                                    <li style="margin-top:10px">
                                        請於
                                        {{ date("Y/m/d", strtotime($cloth_pick_time->start_time)) }}
                                        至
                                        {{ date("Y/m/d", strtotime($cloth_pick_time->end_time)) }}
                                        下午2時至4時，持本繳費單繳款人收執聯至覺生紀念圖書館大門前領取學士服。<br>
                                    </li>
                                </ol>
                            </th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div style="text-align:right;">學位服領取聯</div>
    </div>
</div>
</body>
</html>