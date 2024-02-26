@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/css/custom_uploader.css')}}">
@endpush

@section('title')
    @lang('translate.client')
@endsection

@section('page_header')
    <!-- Basic button -->
    <div class="page-header page-header-light border rounded mb-3">
        <div class="page-header-content d-flex">
            <div class="page-title">
                <h5 class="mb-0">@lang('translate.section_client')</h5>
                <div class="text-muted mt-1">@lang('translate.info_client')</div>
            </div>
            <div class="my-auto ms-auto">
                @can('create_client')
                    <button type="button" class="btn btn-dark" id="create_form_vertical">@lang('translate.add_client')<i
                            class="fa fa-plus ms-2"></i></button>
                @endcan
            </div>
        </div>
        <div class="page-header-content border-top">
            <div class="breadcrumb">
                <a href="/" class="breadcrumb-item py-2">@lang('translate.home')</a>
                <span class="breadcrumb-item active py-2">@lang('translate.client')</span>
            </div>
        </div>
    </div>
    <!-- /basic button -->
@endsection

@section('content')
    <div class="create_section">
    </div>
    <div class="update_section">
    </div>
    <!-- Content area -->
    <div class="content">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">@lang('translate.clients_table')</h5>
            </div>
            <div class="card-body">
            </div>
            <table class="table info_table" id="info_table">
                <thead>
                <tr>
                    <th>@lang('translate.id')</th>
                    <th>@lang('translate.name')</th>
                    <th>@lang('translate.status')</th>
                    <th>@lang('translate.image')</th>
                    <th>@lang('translate.created_at')</th>
                    <th class="text-center">@lang('translate.actions')</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <!-- /content area -->
@endsection
@push('scripts')
    @include('client.script')
@endpush
