@extends('component.create_modal')
@push('modal_type')
    modal-lg
@endpush

@push('modal_header')
    Add User
@endpush
@section('form')
    <form method="post" action="{{ route('admin.store') }}" class="form-validate-jquery" id="main_form">
        {{ csrf_field() }}
        <!-- User Inputs -->
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Name English</label>
                            <input type="text" name="user[full_name]" class="form-control" placeholder="Name English">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Role ID</label>
                            <select name="user[role_id]" id="role" class="form-control">
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{formatRoleName($role)}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="user[email]" class="form-control" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" name="user[password]" id="passwordInput" class="form-control" placeholder="Password">
                                <div class="input-group-append ms-2">
                                    <button id="generatePassword" class="btn btn-outline-dark" type="button"><i class="fas fa-sync"></i> </button>
                                    <button id="togglePasswordVisibility" class="btn btn-outline-dark" type="button"><i class="fas fa-eye"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" name="user[phone]" class="form-control" placeholder="Phone Number">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-dark submit_form">Submit Form<i
                    class="icon-paperplane send_icon ms-2"></i></button>
        </div>
    </form>

@endsection
