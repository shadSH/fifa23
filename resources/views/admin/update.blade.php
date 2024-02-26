@extends('component.update_modal')
@push('modal_type')
    modal-lg
@endpush

@push('modal_header')
   Update User
@endpush
@section('form')
    <form method="post" action="{{route('admin.update',[$user->id])}}" class="form-validate-jquery"
          id="main_form_edit">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <input type="hidden" name="user_id" id="id" value="{{$user->id}}">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Name English</label>
                            <input type="text" name="user[full_name]" class="form-control" placeholder="Name English" value="{{$user->full_name}}">
                        </div>
                    </div>


                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Role ID</label>
                            <select name="user[role_id]" id="role_edit" class="form-control">
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{formatRoleName($role)}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="user[email]" class="form-control" value="{{$user->email}}" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" name="user[phone]" class="form-control" value="{{$user->phone}}" placeholder="Phone Number">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-dark submit_form">Submit Form<i
                    class="icon-paperplane send_icon ml-2"></i></button>
        </div>
    </form>

@endsection

<script>

    $(document).ready(function() {
        var originalRoles = {};

        function updateRolesBasedOnBuilding(buildingId, roleId) {
            if (!originalRoles[roleId]) {
                originalRoles[roleId] = $('#' + roleId).html();
            }
            var selectedType = $('#' + buildingId + ' option:selected').attr('data-type');
            if ($.fn.select2 && $('#' + roleId).data('select2')) {
                $('#' + roleId).select2('destroy');
            }
            $('#' + roleId).html(originalRoles[roleId]);
            if (selectedType === '2') {
                $('#' + roleId + " option").filter(function() {
                    return $(this).text() == 'Camp HR'
                }).remove();
            }
            $('#' + roleId).select2().trigger('change');
        }

        function initializeForm(buildingSelector, roleSelector) {
            $('#' + buildingSelector).off('change').on('change', function() {
                updateRolesBasedOnBuilding(buildingSelector, roleSelector);
            });
            updateRolesBasedOnBuilding(buildingSelector, roleSelector);
        }

        initializeForm('building_id_edit', 'role_edit');

        $("#role_edit").select2({
            dropdownParent: $('#modal_form_vertical_edit')
        });

        $("#building_id_edit").select2({
            dropdownParent: $('#modal_form_vertical_edit')
        });
    });


</script>
