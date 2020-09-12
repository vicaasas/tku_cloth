<html>
<head>
    <meta http-equiv=Content-Type content="text/html; charset=UTF-8">
    <style type="text/css">
    th{
        font-weight:normal;
    }
    </style>
    </head>
<body>
<img src="{{ public_path('pdf/事務組.jpg') }}" style="position:fixed;z-index:-1;width:100%;height:100%">
<div style="width:100%;font-family:標楷體;padding-top:50px;">
@foreach($bill_receipt as $bill_receipt)
    
<div>
    <div style="font-size:60px;text-align:center;font-family:標楷體;margin-left:3%;"><strong>淡江大學畢業班級{{ $degree }}服借用繳費單</strong></div>
</div>

    <div style="margin-left:3%;">
        <table style="font-size:27px;text-align:left;" width="1050">
            <tr height="100">
                <th></th>
                <th>{{ $class_name }}</th>
                <th width="300">班級同學計{{ $order_number->total }}名</th>
                <th></th>
            </tr>
            <tr>
                <th width="150">代收項目： </th>
                <th width="300">洗滌折舊費</th>
                <th>{{ $order_number->total }} 套 x 100元</th>
                <th>{{ $order_number->total * 100 }} 元</th>
            </tr>
            <tr>
                <th></th>
                <th>借用保證金</th>
                <th>{{ $order_number->total }} 套 x 500元</th>
                <th>{{ $order_number->total * 500 }} 元</th>
            </tr>

            <tr height="75">
                <th>代收金額： </th>
                <th>新臺幣</th>
                <th>{{ $order_number->total * 100 + $order_number->total * 500 }} 元整</th>
                <th>事務組經辦人：黃慶文</th>
            </tr>

        </table>

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
                <th width="250" valign="bottom">
                    ({{ $bill_receipt }}收執聯)
                </th>
            </tr>
        </table>
    </div>
    <br>
    <br>
@endforeach

</div>

</body>
</html>