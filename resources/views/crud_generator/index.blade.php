@extends('layouts.app')

@push('styles')

@endpush

@section('title')
    @lang('translate.city')
@endsection


@section('page_header')

    <!-- Basic button -->
    <div class="page-header page-header-light border rounded mb-3">
        <div class="page-header-content d-flex">
            <div class="page-title">
                <h5 class="mb-0">Section CRUD GENERATOR</h5>
                <div class="text-muted mt-1">All Information About CRUD GENERATOR Section</div>
            </div>
        </div>

        <div class="page-header-content border-top">
            <div class="breadcrumb">
                <a href="/" class="breadcrumb-item py-2">Home</a>
                <span class="breadcrumb-item active py-2">CRUD GENERATOR</span>

            </div>
        </div>
    </div>
    <!-- /basic button -->
@endsection
@section('content')
    <!-- Content area -->
    <div class="content">

        <div class="content_field"></div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">CRUD GENERATOR Table</h5>
            </div>

            <div class="card-body">
                <form method="post" action="{{ route('crud-generator.generate') }}" class="form-validate-jquery main_form"
                      id="main_form">
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Model Name</label>
                                <input type="text" class="form-control" name="model_name" required
                                       placeholder="CModel Name">
                            </div>


                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Menu Title</label>
                                <input type="text" class="form-control" name="menu_title"
                                       placeholder="Menu Title">
                            </div>
                        </div>
                    </div>

                    <table class="table info_table">
                        <thead>
                        <tr>
                            <th>Field Type</th>
                            <th>Database Column</th>
                            <th>Required</th>
                            <th>Is Show In Table</th>
                        </tr>
                        </thead>
                        <tbody class="tbody">

                        </tbody>

                    </table>
                  <div class="row">
                      <div class="col-lg-12 text-center">
                          <button  type="button" class="btn-block btn btn-black" id="add_fields">+ ADD FIELDS</button>
                      </div>
                  </div>


                    <div class="text-end">
                        <button type="submit" class="btn btn-dark submit_form">Submit form <i
                                class="icon-paperplane ms-2 send_icon"></i></button>
                    </div>
                </form>

            </div>

        </div>


    </div>
    <!-- /content area -->
@endsection

@push('scripts')
    @include('crud_generator.script')
@endpush



