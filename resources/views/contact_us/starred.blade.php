@extends('contact_us.sidebar')
@section('mail_content')
    <!-- Content area -->
    <div class="content">

        <!-- Single line -->
        <div class="card">
            <div class="card-header bg-transparent header-elements-inline">
                <h6 class="card-title">Starred Mails <i class="icon-stars"></i></h6>
            </div>

            <!-- Action toolbar -->
            <div class="navbar navbar-light navbar-expand-lg border-bottom-0 py-lg-2">
                <div class="text-center d-lg-none w-100">
                    <button type="button" class="navbar-toggler w-100" data-toggle="collapse" data-target="#inbox-toolbar-toggle-single">
                        <i class="icon-circle-down2"></i>
                    </button>
                </div>
            </div>
            <!-- /action toolbar -->


            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-inbox" id="info_table">
                    <tbody data-link="row" class="rowlink">
                    </tbody>
                </table>
            </div>
            <!-- /table -->

        </div>
        <!-- /single line -->

    </div>
    <!-- /content area -->
@endsection

@push('scripts')

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
                    url: "{{route('contact_us.data_starred')}}"
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
        $('#info_table tbody').on('click', 'tr', function () {
            var id = $(this).data('id')
            window.location.href='/contact_us/read/'+id;
        });
    </script>

@endpush



