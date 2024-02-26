@extends('layouts.app')

@push('styles')
    <style>
        .table td, .table th{
            border-top: none !important;
        }
    </style>
@endpush

@section('title')
   Uploaded Files
@endsection



@section('page_header')

    <!-- Basic button -->
    <div class="page-header page-header-light border rounded mb-3">
        <div class="page-header-content d-flex">
            <div class="page-title">
                <h5 class="mb-0">Section Uploaded FIle</h5>
                <div class="text-muted mt-1">All Information About City Section</div>
            </div>

            <div class="my-auto ms-auto">
                @can('add_upload_file')

                    <a href="{{route('uploaded-files.create')}}" class="btn btn-dark" id="create_form_vertical">Add File <i
                            class="fa fa-plus ms-2"></i></a>
                @endcan

            </div>
        </div>

        <div class="page-header-content border-top">
            <div class="breadcrumb">
                <a href="/" class="breadcrumb-item py-2">Home</a>
                <span class="breadcrumb-item active py-2">Uploaded File</span>

            </div>
        </div>
    </div>
    <!-- /basic button -->
@endsection

@section('content')
    <!-- Content area -->
    <div class="content">

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Uploaded Files
                </h5>
            </div>

            <div class="card-body">
            </div>
            <table class="table info_table" id="info_table">
                <thead>
                <tr class="d-none">
                    <th>ID</th>
                </tr>
                </thead>
                <tbody class="row"></tbody>
            </table>
        </div>


    </div>
    <!-- /content area -->
@endsection


<!-- /vertical form modal -->
<div id="info-modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white border-0">
                <h6 class="modal-title">Info Image</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body"  id="info-modal-content">

            </div>


        </div>
    </div>
</div>
<!-- /vertical form modal -->
@push('scripts')
    @include('uploaded_files.script')
@endpush



