<html>
    <head>
        <meta http-equiv=Content-Type content="text/html; charset=UTF-8">

    </head>
<body>

<div style="width:100%;font-family:標楷體;font-size:20px">
@foreach($bill_receipt as $bill_receipt)
    <div style="height:500px">
        <div>
            <div style="font-size:60px;text-align:center;font-family:標楷體;margin-left:3%;"><strong>淡江大學畢業班級{{ $student_data->m_or_b }}服借用預約訂單</strong></div>
        </div>
        <div>406411255 周孝威</div>
        <div>預定的人</div>
        <div>
        備註： 1.請持本單至守謙會議中心HC308事務整備組領取粘存單後，
        至商管大樓B304出納組繳費，並加蓋出納組收費章方為有效。
        事務整備組收執聯須交回事務整備組存查。
        2.繳費期限為2020/04/20至2020/05/01止，逾期視為放棄租借。
        3.請於2020/05/11至2020/05/13下午2時至4時，持本繳費單
        繳款人收執聯至覺生紀念圖書館大門前領取學士服。
        </div>
    </div>
    <div style="text-align:right;">{{ $bill_receipt }}</div>
    <hr style="border:2px black dashed;">
@endforeach
    <div style="height:500px">
        <div>
            <div style="font-size:60px;text-align:center;font-family:標楷體;margin-left:3%;"><strong>淡江大學畢業班級{{ $student_data->m_or_b }}服借用預約訂單</strong></div>
            <div>406411255 周孝威</div>
        <div>
        備註： 1.請持本單至守謙會議中心HC308事務整備組領取粘存單後，
        至商管大樓B304出納組繳費，並加蓋出納組收費章方為有效。
        事務整備組收執聯須交回事務整備組存查。
        2.繳費期限為2020/04/20至2020/05/01止，逾期視為放棄租借。
        3.請於2020/05/11至2020/05/13下午2時至4時，持本繳費單
        繳款人收執聯至覺生紀念圖書館大門前領取學士服。
        </div>
        </div>
    </div>
    <div style="text-align:right;">學位服領取聯</div>
</div>

</body>
</html>