
@extends('component.update_modal')
@push('modal_header')
    Update City
@endpush
@section('form')
    <form method="post" action="{{route('city.update',[$city->id])}}" class="form-validate-jquery main_form_edit" id="main_form_edit">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <input type="hidden" name="id" id="id">
        <div class="mb-3">
            <label class="form-label">City</label>
            <input type="text" class="form-control" name="name" value="{{$city->name}}" id="name" required placeholder="City Name">
        </div>
        <div class="text-end">
            <button type="submit" class="btn btn-dark submit_form">Submit form <i
                    class="icon-paperplane ms-2 send_icon"></i></button>
        </div>
    </form>
@endsection
