@extends('contact_us.sidebar')
        @section('mail_content')
            <div class="content">

                <!-- Single line -->
                <div class="card">
                    <div class="card-header bg-transparent header-elements-inline">
                        <h6 class="card-title">My Inbox</h6>

                        <div class="header-elements">
                            <span class="badge badge-primary">{{$today_mails}} new today</span>
                        </div>
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
        @endsection
@push('scripts')
    @include('contact_us.script')
@endpush

