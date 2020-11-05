<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button"
       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        清單列表
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ route('sub_system.report.all_student_order') }}" target="_blank">學生清單</a>
        <a class="dropdown-item" href="{{ route('sub_system.report.total') }}" target="_blank">總表清單</a>
        <a class="dropdown-item" href="{{ route('sub_system.pdf.not_return','學士') }}" target="_blank">學士未歸還清單</a>
        <a class="dropdown-item" href="{{ route('sub_system.pdf.is_return','學士') }}" target="_blank">學士已歸還名冊</a>
        <a class="dropdown-item" href="{{ route('sub_system.pdf.not_return','碩士') }}" target="_blank">碩士未歸還清單</a>
        <a class="dropdown-item" href="{{ route('sub_system.pdf.is_return','碩士') }}" target="_blank">碩士已歸還名冊</a>
    </div>
</li>
<li>
    <a class="nav-link" href="{{ route('sub_system.pdf.exportCsv') }}">匯出訂單詳細資訊CSV</a>
</li>