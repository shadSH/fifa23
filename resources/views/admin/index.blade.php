@extends('layouts.app')

@push('styles')

@endpush

@section('title')
    Admin
@endsection



@section('page_header')

    <!-- Basic button -->
    <div class="page-header page-header-light border rounded mb-3">
        <div class="page-header-content d-flex">
            <div class="page-title">
                <h5 class="mb-0">Section User</h5>
                <div class="text-muted mt-1">All Information About User Section</div>
            </div>

            <div class="my-auto ms-auto">
                <button type="button" class="btn btn-dark" id="create_form_vertical">Add User <i
                            class="fa fa-plus ms-2"></i></button>
            </div>
        </div>

        <div class="page-header-content border-top">
            <div class="breadcrumb">
                <a href="/" class="breadcrumb-item py-2">Home</a>
                <span class="breadcrumb-item active py-2">User Management</span>
            </div>
        </div>
    </div>
    <!-- /basic button -->
@endsection

@section('content')
    @include('admin.create')
    <div class="update_section">

    </div>
    <!-- Content area -->
    <div class="content">

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">User Table</h5>
            </div>

            <div class="card-body">
            </div>
            <table class="table info_table" id="info_table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Phone</th>
                    <th class="text-center">Role</th>
                    <th class="text-center">Active</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>


    </div>
    <!-- /content area -->
@endsection

@push('scripts')
    @include('admin.script')
@endpush



