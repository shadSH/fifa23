@extends('contact_us.sidebar')
@section('mail_content')
    <!-- Content area -->
    <div class="content">

        <!-- Single mail -->
        <div class="card">

            <!-- Action toolbar -->
            @if(!$contact->deleted_at)
            <div class="navbar navbar-light navbar-expand-lg py-lg-2 rounded-top">
                <div class="text-center d-lg-none w-100">
                    <button type="button" class="navbar-toggler w-100 h-100" data-toggle="collapse" data-target="#inbox-toolbar-toggle-read">
                        <i class="icon-circle-down2"></i>
                    </button>
                </div>

                <div class="navbar-collapse text-center text-lg-left flex-wrap collapse" id="inbox-toolbar-toggle-read">
                    <div class="mt-3 mt-lg-0 mr-lg-3">
                        <div class="btn-group">
                            <button type="button" class="btn btn-light">
                                <i class="icon-reply"></i>
                                <span class="d-none d-lg-inline-block ml-2" ><a href="#" id="reply_button" data-id="{{$contact->id}}">Reply</a></span>
                            </button>
                            <button type="button" class="btn btn-light">
                                <i class="icon-bin"></i>
                                <span class="d-none d-lg-inline-block ml-2"><a href="#" id="delete_mail" data-id="{{$contact->id}}" data-route="{{route("contact_us.destroy", [ $contact->id])}}" >Delete</a></span>

                            </button>
                        </div>
                    </div>

                    <div class="navbar-text ml-lg-auto">{{$contact->created_at->diffForHumans()}}</div>
                </div>

            </div>
            <!-- /action toolbar -->

            @endif
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
                        <div class="letter-icon-title font-weight-semibold">{{$contact->full_name}} <a href="#">&lt;{{$contact->email}}&gt;</a></div>
                    </div>
                </div>
            </div>
            <!-- /mail details -->


            <!-- Mail container -->
            <div class="card-body">
                <div class="overflow-auto mw-100">
                    <p>{{$contact->message}}</p>

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



