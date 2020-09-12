<div class="container">
    <div class="container text-center h2">
        您好，{{ $user->student_name }} 同學
    </div>
    <a href="pdf/Receipt.pdf" target="_blank">列印保證金繳費證明</a>
    <a href="pdf/Receipt1.pdf" target="_blank">列印洗滌及折舊費繳費證明</a>
    <form action="{{ route('order.save') }}/{{ $user->class_name }}" method="post">
        @csrf
        <div class="form-group row">

            
            <div class="col-md-6">
                <input id="location" type="text" name="size" placeholder="衣服尺寸">
                <input id="location" type="text" name="accessory" placeholder="配件顏色">
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
