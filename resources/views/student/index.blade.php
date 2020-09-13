<div class="container">
    <div class="container text-center h2">
        您好，{{ $user->student_name }} 同學
    </div>
    <ul>
    {{ $order }}
    @foreach($order as $order)
    {{ $order->stu_id }}
    @endforeach
    </ul>
    
    <a href="pdf/Receipt.pdf" target="_blank">列印保證金繳費證明</a>
    <a href="pdf/Receipt1.pdf" target="_blank">列印洗滌及折舊費繳費證明</a>
    <form action="{{ route('order.save') }}" method="post">
        @csrf
        <div class="form-group row">

        <div class="col-md-6">
            <input type="text" name="order_property[0][size]" placeholder="尺寸">
            <input type="text" name="order_property[0][color]" placeholder="顏色">
        </div>
        <div class="col-md-6">
            <input type="text" name="order_property[1][size]" placeholder="尺寸">
            <input type="text" name="order_property[1][color]" placeholder="顏色">
        </div>
        <div class="col-md-6">
            <input type="text" name="order_property[2][size]" placeholder="尺寸">
            <input type="text" name="order_property[2][color]" placeholder="顏色">
        </div>
        {{--
        @foreach($cloth_config as $cloth_config)
        <label for="location" class="col-md-4 col-form-label text-md-right">
            {{ $cloth_config->property }}
        </label>
        <div class="col-md-6">
            <input id="{{ $cloth_config->property }}" type="text" name="size" placeholder="數量">
        </div>
        @endforeach--}}
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
