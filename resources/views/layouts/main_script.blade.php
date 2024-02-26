<script src="{{asset('assets/js/vendors.js?v=2.1')}}"></script>
<!-- Core JS files -->
<script src="{{asset('global_assets/js/jquery/jquery.min.js')}}"></script>
<script src="{{asset('global_assets/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/app.js')}}"></script>
<script src="{{asset('global_assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
<script src="{{asset('global_assets/js/vendor/notifications/noty.min.js')}}"></script>
<script src="{{asset('global_assets/demo/pages/datatables_basic.js')}}"></script>
<script src="{{asset('global_assets/demo/pages/extra_noty.js')}}"></script>
<script src="{{asset('global_assets/js/vendor/forms/selects/select2.min.js')}}"></script>
<script src="{{asset('global_assets/js/vendor/notifications/sweet_alert.min.js')}}"></script>

<script src="{{asset('/assets/js/functions.js')}}"></script>
<script src="{{asset('/assets/js/aiz_configration.js')}}"></script>
<script src="{{asset('/assets/js/initialize_sweetalert.js')}}"></script>

<!-- /core JS files -->

<script>


    $(document).ready(function() {
        $('.page-header.mb-3').removeClass('mb-3').addClass('m-3');


        //button create
        $("#create_form_vertical").click(function () {
            trigger_and_showing_modal()
        })

        // for creating
        $(document).on("submit","#main_form", function (e) {
            e.preventDefault();
            send_ajax_request_form(this)
        })

        //for updating
        $(document).on("submit","#main_form_edit", function (e) {
            e.preventDefault();
            send_ajax_request_form(this,'#modal_form_vertical_edit','#info_table')
        })

        // for deleting
        $(document).delegate("#delete", "click", function () {

            var id = $(this).data("id");
            var route = $(this).data("route");

            swalInit.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this imaginary file!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.value === true) {
                    send_ajax_request('DELETE','{{csrf_token()}}' , route, id , 'Record deleted successfully!' , 'success' ,'#info_table' )
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            })

            return false;
        })
        $(document).delegate(".checkbox_change_status", "change", function () {
            var id = $(this).data("id");
            var route = $(this).data("route");
            send_ajax_request('GET','{{csrf_token()}}',route, id , 'Successfully status change' , 'success' ,'#info_table' )
            return false;
        })

        var name_datatable = '#info_table';
        $(name_datatable).on('page.dt', function () {
            $('#loading').show();
        });

        $(name_datatable).on('draw.dt', function () {
            $('#loading').hide();
        });

        $(name_datatable).on('search.dt', function () {
            $('#loading').show();
        });

        if ($(name_datatable).length) {
            $.extend($.fn.dataTable.defaults, {
                initComplete: function () {
                    $('#loading').hide();
                },
            });
        } else {
            $('#loading').hide();
        }

        $('.sp-container').css('text-align','center')


        $(document).on('click','#workflow_status',function () {
            var id = $(this).data("id");
            var route = $(this).data("route");
            var data = {};
            var view_return = '.canvas_body_tracking';
            send_ajax_request_view_return('GET',route , data , view_return)

        })


    })
</script>

@stack('scripts')
