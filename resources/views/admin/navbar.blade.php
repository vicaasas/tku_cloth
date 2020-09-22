<li class="nav-item @yield('nav_return')">
    <a class="nav-link" href="{{ route('return.cloths.page') }}">物品歸還</a>
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
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button"
       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        清單列表
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ route('report.all_student_order') }}" target="_blank">學生清單</a>
        <a class="dropdown-item" href="{{ route('report.total') }}" target="_blank">總表清單</a>
        <a class="dropdown-item" href="{{ route('report.not_return') }}" target="_blank">未歸還清單</a>
        <a class="dropdown-item" href="{{ route('report.is_return') }}" target="_blank">已歸還名冊</a>
    </div>
</li>
<li>
    <a class="nav-link" href="{{ route('report.exportCsv') }}">匯出訂單詳細資訊CSV</a>
</li>