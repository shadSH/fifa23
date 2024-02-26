// for translating
$(".translate").click(function (){
    var name_en = $(".name_en").val();
    var name_ku = $(".name_ku").val();
    var name_ar = $(".name_ar").val();
    $.ajax({
        type: 'GET',
        url: "{{route('translate.all')}}",
        data: {
            "_token": "{{csrf_token()}}",
            name_en: name_en,
            name_ku: name_ku,
            name_ar: name_ar,
        },
        success: function (response) {
            $(".name_en").val(response.name_en);
            $(".name_ku").val(response.name_ku);
            $(".name_ar").val(response.name_ar);
        }
    });
});
$(".translate_update").click(function (){
    var name_en = $(".name_en").val();
    var name_ku = $(".name_ku").val();
    var name_ar = $(".name_ar").val();
    $.ajax({
        type: 'GET',
        url: "{{route('translate.all')}}",

        data: {
            "_token": "{{csrf_token()}}",
            name_en: name_en,
            name_ku: name_ku,
            name_ar: name_ar,
        },
        beforeSend: function () {

            $('.icon_translate').removeClass('icon-earth');
            $('.icon_translate').addClass('fa fa-spinner fa-spin');
        },
        complete: function () {
            $('.icon_translate').removeClass('fa fa-spinner fa-spin');
            $('.icon_translate').addClass('icon-earth');

        },
        success: function (response) {

            $(".name_en").val(response.name_en);
            $(".name_ku").val(response.name_ku);
            $(".name_ar").val(response.name_ar);
        }
    });
});
