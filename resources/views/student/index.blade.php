<div class="container">
    <div class="container text-center h2">
        您好，{{ $user->student_name }} 同學
    </div>
    <ul>
    {{ $user }}
    <br>
    {{ $student_class_data }}
    <br>
    學生訂單
    <br>
    {{ $student_order }}
    <br>
    {{ $cloth_remainder }}
    </ul>
    
    <a href="pdf/Receipt.pdf" target="_blank">列印保證金繳費證明</a>
    <a href="pdf/Receipt1.pdf" target="_blank">列印洗滌及折舊費繳費證明</a>
    <form action="{{ route('order.save') }}" method="post">
        @csrf
        <div class="form-group row">

        <div class="col-md-6">
            <input type="text" name="order_property[0][student_id]" placeholder="學號">

            <input type="text" name="order_property[0][size]" placeholder="尺寸">
            <input type="text" name="order_property[0][color]" placeholder="顏色">
        </div>
        <div class="col-md-6">
        <input type="text" name="order_property[1][student_id]" placeholder="學號">

            <input type="text" name="order_property[1][size]" placeholder="尺寸">
            <input type="text" name="order_property[1][color]" placeholder="顏色">
        </div>
        <div class="col-md-6">
        <input type="text" name="order_property[2][student_id]" placeholder="學號">

            <input type="text" name="order_property[2][size]" placeholder="尺寸">
            <input type="text" name="order_property[2][color]" placeholder="顏色">
        </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    新增訂單
                </button>
            </div>
        </div>
    </form>
    <form action="{{ route('order.student_all_order_delete') }}" method="post">
        @csrf
        <div class="form-group row">

        <div class="col-md-6">
            <input type="text" name="order_id" placeholder="id">
        </div>

        </div>
        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    新增訂單
                </button>
            </div>
        </div>
    </form>
</div>
