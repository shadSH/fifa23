<!-- Main navbar -->
<div class="navbar navbar-dark navbar-expand-lg navbar-static border-bottom border-bottom-white border-opacity-10">
    <div class="container-fluid">
        <div class="d-flex d-lg-none me-2">
            <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
                <i class="ph-list"></i>
            </button>
        </div>

        <div class="navbar-brand flex-1 flex-lg-0">
            <a href="/" class="d-inline-flex align-items-center">
                <img src="{{asset('img/icon.png')}}" alt="">
                {{--                <img src="{{asset('img/techno-login.aeafeb5b.png')}}" class="d-none d-sm-inline-block h-16px ms-3" alt="">--}}
            </a>
        </div>



        <div class="navbar-collapse justify-content-center flex-lg-1 order-2 order-lg-1 collapse" id="navbar_search">
            @if($MODE == 'dark')
                <a href="{{route('mode',['light'])}}" class="navbar-nav-link navbar-nav-link-icon rounded-pill">

                    <i class="fa fa-sun"></i>
                </a>
            @else
                <a href="{{route('mode',['dark'])}}" class="navbar-nav-link navbar-nav-link-icon rounded-pill">

                    <i class="fa fa-moon"></i>
                </a>
            @endif
        </div>

        <ul class="nav flex-row justify-content-end order-1 order-lg-2">




            <li class="nav-item nav-item-dropdown-lg dropdown language-switch">
                <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded-pill" data-bs-toggle="dropdown">
                    <img src="{{Config::get('languages')[App::getLocale()]['flag-icon']}}" height="22" alt="">
                    <span class="d-none d-lg-inline-block ms-2 me-1">{{Config::get('languages')[App::getLocale()]['display']}}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    @foreach (Config::get('languages') as $lang => $language)
                        @if ($lang != App::getLocale())
                            <a href="{{ route('lang', $lang) }}" class="dropdown-item en">
                                <img src="{{$language['flag-icon']}}" height="22" alt="">
                                <span class="ms-2">{{$language['display']}}</span>
                            </a>

                        @endif
                    @endforeach

                </div>
            </li>



            <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                <a href="#" class="navbar-nav-link align-items-center rounded-pill p-1" data-bs-toggle="dropdown">
                    <div class="">
                        <img src="{{asset('img/icon.png')}}" class="w-32px h-32px rounded-pill" alt="">
                        <span class="status-indicator bg-success"></span>
                    </div>
                    <span class="d-none d-lg-inline-block mx-lg-2">{{Auth::user()->name}}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-end">
                    <a href="{{route('users.setting')}}" class="dropdown-item">
                        <i class="ph-gear me-2"></i>
                        @lang('translate.account_setting')
                    </a>
                    <a href="/logout" class="dropdown-item">
                        <i class="ph-sign-out me-2"></i>
                        @lang('translate.logout')
                    </a>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->
