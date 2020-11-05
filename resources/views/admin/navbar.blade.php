@if(Gate::check('admin') || Gate::check('sub_admin') )
    <li class="nav-item @yield('nav_return')">
        <a class="nav-link" href="{{ route('return.page') }}">物品歸還</a>
    </li>
    <li>
        <a class="nav-link" href="{{ route('system.index') }}">系統設定</a>
    </li>
    <li>
        <a class="nav-link" href="{{ route('get_cloths_view') }}">衣物領取</a>
    </li>
    <li>
        <a class="nav-link" href="{{ route('print.bill') }}">繳費收據登記</a>
    </li>
    <li>
        <a class="nav-link" href="{{ route('return.refund_view') }}">退款</a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            清單列表
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('report.all_student_order') }}" target="_blank">學生清單</a>
            <a class="dropdown-item" href="{{ route('report.total') }}" target="_blank">總表清單</a>
            <a class="dropdown-item" href="{{ route('pdf.not_return','學士') }}" target="_blank">學士未歸還清單</a>
            <a class="dropdown-item" href="{{ route('pdf.is_return','學士') }}" target="_blank">學士已歸還名冊</a>
            <a class="dropdown-item" href="{{ route('pdf.not_return','碩士') }}" target="_blank">碩士未歸還清單</a>
            <a class="dropdown-item" href="{{ route('pdf.is_return','碩士') }}" target="_blank">碩士已歸還名冊</a>
        </div>
    </li>
    <li>
        <a class="nav-link" href="{{ route('pdf.exportCsv') }}">匯出訂單詳細資訊CSV</a>
    </li>
@elseif(Gate::check('give_cloth_people'))
    <li>
        <a class="nav-link" href="{{ route('get_cloths_view') }}">衣物領取</a>
    </li>
@endif
