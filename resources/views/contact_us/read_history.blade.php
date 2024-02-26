@extends('contact_us.sidebar')
@section('mail_content')
    <!-- Content area -->
    <div class="content">

        <!-- Single mail -->
        <div class="card">
            <!-- Mail details -->
            <div class="card-body">
                <div class="media flex-column flex-lg-row">
                    <a href="#" class="d-none d-lg-block mr-lg-3 mb-3 mb-lg-0">
									<span class="btn btn-teal btn-icon btn-lg rounded-pill">
										<span class="letter-icon"></span>
									</span>
                    </a>

                    <div class="media-body">
                        <h6 class="mb-0">{{$contact->subject}}</h6>
                        <div class="letter-icon-title font-weight-semibold"><a href="#">&lt;{{$contact->from}}&gt;</a> ---> <a href="#">&lt;{{$contact->to}}&gt;</a></div>
                    </div>
                </div>
            </div>
            <!-- /mail details -->


            <!-- Mail container -->
            <div class="card-body">
                <div class="overflow-auto mw-100">
                    <p>{!! $contact->message !!}</p>

                </div>
            </div>
            <!-- /mail container -->

        </div>
        <!-- /single mail -->

    </div>
    <div class="reply">

    </div>
    <!-- /content area -->
    @endsection

@push('scripts')
    @include('contact_us.script')
@endpush



