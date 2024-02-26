@extends('component.create_modal')

@section('form')
    <form  method="post" action="{{ route('city.store') }}" class="form-validate-jquery main_form" id="main_form">
        {{ csrf_field() }}

        <div class="mb-3">
            <x-label>City Name</x-label>
            <x-input type="text" name="name" placeholder="City Name" required="required"></x-input>
        </div>


        <div class="text-end">
            <button type="submit" class="btn btn-dark submit_form">Submit form <i class="icon-paperplane ms-2 send_icon"></i></button>
        </div>
    </form>
@endsection

