
<script src="{{asset("global_assets/js/plugins/editors/ckeditor/ckeditor.js")}}"></script>
<script>
    $(document).ready(function () {
        CKEDITOR.replace('editor-full', {
            height: 400
        });
        $("#info_table").DataTable({
            processing: true,
            "order": [[0, "desc"]],
            serverSide: true,
            "drawCallback": function( settings ) {
                $("#info_table thead").remove(); } ,
            columnDefs: [{
                targets: [ 3 ]
            }],
            ajax: {
                url: "{{route('contact_us.data')}}"
            },
            columns: [
                {
                    data: "starred",
                    name: "starred"
                },
                {
                    data: "avatar",
                    name: "avatar",
                },
                {
                    data: "full_name",
                    name: "full_name",
                },{
                    data: "subject",
                    name: "subject",
                },
                {
                    data: "message",
                    name: "message"
                }
                ,
                {
                    data: "created_at",
                    name: "created_at"
                }
            ]
        });
    })
    var swalInit = swal.mixin({
        buttonsStyling: false,
        confirmButtonClass: 'btn btn-outline-danger',
        cancelButtonClass: 'btn btn-light'
    });
    $(document).delegate("#delete_mail", "click", function () {
        var id = $(this).data("id");
        var route = $(this).data("route");
        swalInit.fire({
            title: 'Are you sure?',
            text: 'Are you sure deleting this received Email ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.value == true) {
                $.ajax({
                    type: 'DELETE',
                    url: route,
                    data: {
                        "_token": "{{csrf_token()}}",
                        id: id
                    }, error: function (jqXHR, textStatus, errorThrown) {
                        new PNotify({
                            title: 'Something went wrong',
                            text: `Please try again`,
                            addclass: 'bg-danger border-danger',
                            delay: 3000
                        });
                    },
                    success: function (response) {


                        if (response.status == true) {
                            new PNotify({
                                text: "Mail deleted successfully!",
                                addclass: 'bg-success border-success text-white',
                                delay: 3000
                            });
                            window.location.href = "{{route('contact_us.index')}}";
                        }

                    }
                });
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        })


        return false;

    })

    $(document).on("click", "#reply_button", function () {
        var id = $(this).data('id');
        $.ajax({
            url: "{{url('/contact_us')}}/" + id+'/reply',
            type: "GET",
            dataType: "json",
            success: function (data) {
                $(".reply").html(data.html);
                $("#modal_form_vertical_reply").modal('show');
            }
        });
    })
    $('#info_table tbody').on('click', 'tr', function () {
        var id = $(this).data('id')
        window.location.href='/contact_us/read/'+id;
    });
</script>
