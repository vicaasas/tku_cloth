<nav class="navbar fixed-top navbar-expand-sm navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            首頁
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <ul class="navbar-nav mr-auto">
            
                @can('admin')
                    @include('admin.navbar')
                @elsecan('student')
                    @include('student.navbar')
                @endcan
            </ul>
            @guest
                <div class="navbar-nav">
                    <a class="nav-link" href="{{ route('login') }}">
                        登入
                    </a>
                </div>
            @else
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @can('student')
                                {{ Auth::guard('student')->user()->student_name }} 同學你好
                            @else
                                {{ Auth::user()->name }} 管理者你好
                            @endcan
                            
                            <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profile') }}">
                                個人設定
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                登出
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            @endguest
        </div>
    </div>
</nav>

{{--<a href="http://163.13.178.165/clothes/admin/index">系統設定</a>--}}
{{--<a href="http://163.13.178.165/clothes/admin/receiptreg">繳費收據登記</a>--}}
{{--<a href="http://163.13.178.165/clothes/admin/returnclothes">學/碩士服歸還</a>--}}
