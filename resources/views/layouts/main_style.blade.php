<!-- Global stylesheets -->
<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
      type="text/css">
<!-- Global stylesheets -->
<link href="{{asset('global_assets/fonts/inter/inter.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('global_assets/icons/phosphor/styles.min.css')}}" rel="stylesheet" type="text/css">
@if($DIRECTION == 'ltr')
    <link href="{{asset('assets/css/ltr/all.min.css')}}" id="stylesheet" rel="stylesheet" type="text/css">
@else
    <link href="{{asset('assets/css/rtl/all.min.css')}}" id="stylesheet" rel="stylesheet" type="text/css">
@endif
<!-- /global stylesheets -->

<!-- Font Awesome icon set -->
<link href="{{asset('global_assets/icons/fontawesome/styles.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('global_assets/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
<style>


</style>

@stack('styles')
