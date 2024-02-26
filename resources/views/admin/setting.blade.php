@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/css/custom_uploader.css')}}">
@endpush
@section('title')
    User Settings
@endsection


@section('page_header')

    <!-- Basic button -->
    <div class="page-header page-header-light border rounded mb-3">
        <div class="page-header-content d-flex">
            <div class="page-title">
                <h5 class="mb-0">Section User Password</h5>
                <div class="text-muted mt-1">All Information About User Password Section</div>
            </div>

            <div class="my-auto ms-auto">

            </div>
        </div>

        <div class="page-header-content border-top">
            <div class="breadcrumb">
                <a href="/" class="breadcrumb-item py-2">Home</a>
                <span class="breadcrumb-item active py-2">User Password </span>
            </div>
        </div>
    </div>
    <!-- /basic button -->
@endsection

@section('content')
    <div class="row m-4">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0 h6">{{('Change Password')}}</h1>
                </div>
                <div class="card-body">
                    <form class="form-horizontal main_form" id="main_form" action="{{ route('users.change_password') }}" method="POST"
                          enctype="multipart/form-data" >
                        {{ csrf_field() }}

                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Current Password:</label>
                            <div class="col-lg-9">
                                <input type="password" class="form-control" id="" name="current_password" value="" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">New Password:</label>
                            <div class="col-lg-9">
                                <input type="password" class="form-control" id="" name="password" value="" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Password confirmation:</label>
                            <div class="col-lg-9">
                                <input type="password" class="form-control" id="" name="password_confirmation" value="" required>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-dark submit_form">Submit Form<i
                                    class="icon-paperplane send_icon ms-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection



