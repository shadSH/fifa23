@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/css/custom_uploader.css')}}">
@endpush

@section('title')
    Home Page Settings
@endsection
@section('meta_title')
    <meta name="route_dir" content="uploads_all">
@endsection
@section('page_header')

    <!-- Basic button -->
    <div class="page-header page-header-light border rounded mb-3">
        <div class="page-header-content d-flex">
            <div class="page-title">
                <h5 class="mb-0">Section Uploaded FIle</h5>
                <div class="text-muted mt-1">All Information About Upload Section</div>
            </div>

            <div class="my-auto ms-auto">
                @can('add_upload_file')

                    <a href="{{route('uploaded-files.index')}}" class="btn btn-dark" id="create_form_vertical">Back to uploaded files </a>
                @endcan

            </div>
        </div>

        <div class="page-header-content border-top">
            <div class="breadcrumb">
                <a href="/" class="breadcrumb-item py-2">Home</a>
                <span class="breadcrumb-item active py-2">Uploaded New File</span>

            </div>
        </div>
    </div>
    <!-- /basic button -->
@endsection
@section('content')


<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{('Drag & drop your files')}}</h5>
    </div>
    <div class="card-body">
        <div class="tab-pane h-100" id="aiz-upload-new">
            <div id="aiz-upload-files" class="h-100">

            </div>
        </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{asset('assets/js/aiz-core.js?v=1')}}"></script>

    <script type="text/javascript">
		$(document).ready(function() {
			AIZ.plugins.aizUppy();
		});
	</script>
@endpush
