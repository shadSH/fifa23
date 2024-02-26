@extends('layouts.app')

@push('styles')

@endpush

@section('title')
   Contact Us
@endsection



@section('page_header')

    <!-- Basic button -->
    <div class="page-header page-header-light border rounded mb-3">
        <div class="page-header-content d-flex">
            <div class="page-title">
                <h5 class="mb-0">Section Contact Us</h5>
                <div class="text-muted mt-1">All Information About Contact Section</div>
            </div>

            <div class="my-auto ms-auto">

            </div>
        </div>

        <div class="page-header-content border-top">
            <div class="breadcrumb">
                <a href="/" class="breadcrumb-item py-2">Home</a>
                <span class="breadcrumb-item active py-2">Contact Us</span>

            </div>
        </div>
    </div>
    <!-- /basic button -->
@endsection

@section('content')
    <!-- Content area -->
    <div class="page-content">
        <!-- /secondary sidebar -->
        <div class="sidebar sidebar-light sidebar-secondary sidebar-expand-lg">

            <!-- Expand button -->
            <button type="button" class="btn btn-sidebar-expand sidebar-control sidebar-secondary-toggle">
                <i class="icon-arrow-right13"></i>
            </button>
            <!-- /expand button -->


            <!-- Sidebar content -->
            <div class="sidebar-content">

                <!-- Header -->
                <div class="sidebar-section sidebar-section-body d-flex align-items-center">
                    <h5 class="mb-0">Contact Us Mails</h5>
                    <div class="ml-auto">
                        <button type="button" class="btn btn-outline-light text-body border-transparent btn-icon rounded-pill btn-sm sidebar-control sidebar-secondary-toggle d-none d-lg-inline-flex">
                            <i class="icon-transmission"></i>
                        </button>

                        <button type="button" class="btn btn-outline-light text-body border-transparent btn-icon rounded-pill btn-sm sidebar-mobile-secondary-toggle d-lg-none">
                            <i class="icon-cross2"></i>
                        </button>
                    </div>
                </div>
                <!-- /header -->


                <!-- Action -->
                <div class="sidebar-section">
                    <div class="sidebar-section-body pt-0">
                        <a href="#" class="btn btn-indigo btn-block" id="create_form_vertical">Compose mail</a>
                    </div>
                </div>
                <!-- /action -->


                <!-- Sub navigation -->
                <div class="sidebar-section">

                    <ul class="nav nav-sidebar my-2" data-nav-type="accordion">
                        <li class="nav-item-header">Folders</li>
                        <li class="nav-item">
                            <a href="{{route('contact_us.index')}}" class="nav-link {{ request()->is('contact_us') ? 'active' : '' }}">
                                <i class="icon-drawer-in"></i>
                                Inbox
                                <span class="badge badge-success badge-pill ml-auto">{{$inbox}}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('contact_us.sent')}}" class="nav-link {{ request()->is('contact_us/sent') ? 'active' : '' }}"><i class="icon-drawer-out"></i> Sent mail</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('contact_us.starred_mails')}}" class="nav-link {{ request()->is('contact_us/starred') ? 'active' : '' }}"><i class="icon-stars"></i> Starred
                                <span class="badge badge-success badge-pill ml-auto">{{$starred}}</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('contact_us.trash')}}" class="nav-link {{ request()->is('contact_us/trash') ? 'active' : '' }}"><i class="icon-bin"></i> Trash</a>
                        </li>
                    </ul>
                </div>
                <!-- /sub navigation -->


            </div>
            <!-- /sidebar content -->

        </div>

        <div class="content-wrapper">

            <!-- Inner content -->
            <div class="content-inner">

                <!-- Page header -->
                <div class="page-header page-header-light">
                    <div class="page-header-content header-elements-lg-inline">
                        <div class="page-title d-flex">
                            <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Mailbox</span></h4>
                            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
                        </div>
                    </div>
                </div>
                <!-- /page header -->


                <!-- Content area -->
                @yield('mail_content')
                <!-- /content area -->
            </div>
            <!-- /inner content -->

        </div>

    </div>
    <!-- /content area -->
    @include('contact_us.write')
@endsection



