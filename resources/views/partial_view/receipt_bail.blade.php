<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
<div style="font-size:40px;position:fixed;top:-10px">{{ substr($student_data->class_id,1,1) }}</div>
<div style="font-size:20px;text-align:right;padding-top:10px">編號：</div>

    <div style="border:3px black solid;height:610px;width:100%;font-size:25px;font-family:標楷體;">
        <p style="font-size:50px;text-align:center;">
            保證金繳費證明
        </p>
        <div style="margin-left:200px;">
            <div>
                茲收到<strong><span style="margin-left:100px">{{ $student_data->class_name }}</span><span style="margin-left:100px">{{ $student_data->student_name }}</span></strong><span style="margin-left:100px">同學</span>
            </div>
            <div style="margin-left:200px;">
                借用{{ $student_data->m_or_b }}服一套保證金計{{ $student_data->margin }}元整。
            </div>
            <div>
            經手人：
                <img src="{{ asset('image\people_hand.jpg') }}" style="height:60px;width:120px;">
                <span style="margin-left:50px;"><img src="" style="height:70px;width:550px"></span>
                <!-- <img src="http://163.13.178.165/examples.php?barcode={{ $student_data->student_id }}" style="height:70px;width:550px"> -->
            </div>
            <span style="position:fixed;margin-left:500px">{{ $student_data->student_id }}</span>
        </div>
            <br>
            <br>
        <div style="margin-left:100px">
            <div>注意事項:</div>
            <div>
            一、請於{{ $year }}{{ date("年m月d日", strtotime($return_due_date->end_time)) }}前，持本聯及{{ $student_data->m_or_b }}服至{{ $collection_place->value }}辦理歸還<br>
            　　及領回保證金{{ $student_data->margin }}元。
            </div>
            <div>
            二、服裝如有毀損或非本校學士服之情事者，須照價賠償，價目如下：<br>
            　　衣服：{{ $student_data->clothes }}元、帽子(連帽穗)：{{ $student_data->hat }}元<br>
            　　領巾：{{ $student_data->scarf }}元、帽穗：{{ $student_data->hatear }}元
            </div>
            <br>
            <div style="position:fixed;z-index:3;top:480px;left:980px">淡江大學</div>
            <img src="{{ asset('image\receipt.jpg') }}" style="width:150px;height:150px;position:fixed;z-index:2;top:450px;left:950px">
            <div style="position:fixed;z-index:3;top:550px;left:990px">總務處</div>
            <div style="font-size:40px;margin-left:100px;letter-spacing: 10px;">中華民國 {{ $year }} 年 {{ $month }} 月 {{ $day }} 日</div>
            <div style="font-size:40px;position:fixed;margin-top:10px;left:1050px">{{ substr($student_data->class_id,2,2) }}{{ substr($student_data->student_id,0,1) }}</div>
            <br>
        </div>
        <div style="font-size:26px;">
                <div>保證金受款人簽名：____________,<span>委託代領人簽名:_____________(受款人自領免填)</span></div>
                <div>連絡電話：_______________</div>
            </div>
    </div>
</body>
</html>