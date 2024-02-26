<script src="{{asset('assets/js/aiz-core.js?v=1')}}"></script>
<script src="{{asset("global_assets/js/plugins/forms/selects/select2.min.js")}}"></script>
<script>
    function load_js() {
        var head = document.getElementsByTagName('head')[0];
        var script = document.createElement('script');
        script.src = "{{asset('assets/js/aiz-core.js?v=1')}}";
        head.appendChild(script);
    }
    $(document).ready(function () {
        $("#info_table").DataTable({
            processing: true,
            "order": [[0, "desc"]],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/{{ (App::getLocale() == 'ckb' ) ? 'ku' : App::getLocale() }}.json",
                searchPlaceholder: "{{ __('translate.search_records') }}"
            },
            serverSide: true,
            columnDefs: [{
                targets: [3]
            }],
            ajax: {
                url: "{{route('clients.data')}}"
            },
            columns: [
                {
                    data: "id",
                    name: "id"
                },
                {
                    data: "name",
                    name: "name",
                },
                {
                    data: "checkbox",
                    name: "checkbox",
                },
                {
                    data: "image",
                    name: "image"
                },
                {
                    data: "created_at",
                    name: "created_at"
                },
                {
                    data: "action",
                    name: "action",
                    "class": "text-center",
                }
            ]
        });
        $(document).on("click", "#edit", function () {
            var id = $(this).data('id');
            $.ajax({
                url: "{{url('/clients')}}/" + id + '/edit',
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('.update_section').html(data.html);
                    $('#main_form_edit').attr('action', data.route);
                    load_js();
                    $("#modal_form_vertical_edit").modal("show");
                }
            });
        })

    })
</script>
