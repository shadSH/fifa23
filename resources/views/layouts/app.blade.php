@php
    $DIRECTION = Config::get('languages')[App::getLocale()]['dir'];
    $MODE =  Config::get('app.mode_theme');
    $lang = Session()->get('applocale');

@endphp
<!DOCTYPE html>
<html lang="{{$lang}}" dir="{{$DIRECTION}}" data-color-theme="{{$MODE}}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ getBaseURL() }}">
    <meta name="file-base-url" content="{{ getFileBaseURL() }}">
    @yield('meta_title')
    <title>@yield('title')</title>

    <!-- Global stylesheets -->
    @include('layouts.main_style')
    <!-- /global stylesheets -->



</head>

<body>


@include('layouts.main_navbar')


<!-- Page content -->
<div class="page-content">


    @include('layouts.main_sidebar')


    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Inner content -->
        <div class="content-inner">

            @yield('page_header')


            @yield('content')




           @include('layouts.footer')

        </div>
        <!-- /inner content -->

    </div>
    <!-- /main content -->

</div>
<!-- /page content -->



@include('layouts.main_script')
</body>
</html>
