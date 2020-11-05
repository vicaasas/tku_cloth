<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
<div style="font-size:30px;text-align:right;padding-top:10px">編號：{{ substr($student_data->class_id,0,4) }}-{{ substr($student_data->student_id,0,3) }}</div>

    <div style="border:3px black solid;height:610px;width:100%;font-size:25px;font-family:標楷體;">
        <p style="font-size:50px;text-align:center;">
            洗滌及折舊費繳費證明
        </p>
        <div style="margin-left:200px;">
            <div>
                茲收到<strong><span style="margin-left:100px">{{ $student_data->class_name }}</span><span style="margin-left:100px">{{ $student_data->student_name }}</span></strong><span style="margin-left:100px">同學</span>
            </div>
            <div style="margin-left:200px;">
                借用{{ $student_data->m_or_b }}服一套洗滌及折舊費計{{ $student_data->cleanfee }}元整。
            </div>
            <div>
            經手人：
                <img src="{{ asset('image\people_hand.jpg') }}" style="height:60px;width:120px;">
            </div>
        </div>
            <br>
            <br>
        <div style="margin-left:100px">
            <div>注意事項:  本聯僅作為繳費證明之用。</div>

            <br>
            <div style="position:fixed;z-index:3;top:470px;left:980px">淡江大學</div>
            <img src="{{ asset('image\receipt.jpg') }}" style="width:150px;height:150px;position:fixed;z-index:2;top:440px;left:950px">
            <div style="position:fixed;z-index:3;top:540px;left:990px">總務處</div>
            <div style="font-size:40px;margin-left:100px;letter-spacing: 10px;">中華民國 {{ $year }} 年 {{ $month }} 月 {{ $day }} 日</div>
            <br>
        </div>

    </div>
</body>
</html>