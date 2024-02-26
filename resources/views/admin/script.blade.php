{{--<script src="{{asset('global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>--}}
<script>
    $(document).ready(function () {

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

        initializeForm('building_id', 'role');


        $(document).delegate("#update_password", "click", function () {

            var id = $(this).data("id");
            var route = $(this).data("route");

            swalInit.fire({
                title: 'Are you sure?',
                text: 'Dou you change password!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Change!'
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.value === true) {
                    send_ajax_request('GET','{{csrf_token()}}' , route, id , 'Password Update Successfully' , 'success' ,'#info_table' , true , 'password')
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            })

            return false;
        })

        $('#generatePassword').on('click', function() {
            const generatedPassword = generateRandomPassword(14);
            $('#passwordInput').val(generatedPassword);
        });

        $('#togglePasswordVisibility').on('click', function() {
            const passwordInput = $('#passwordInput');
            const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
            passwordInput.attr('type', type);
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');
        });

        function generateRandomPassword(length) {
            const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+";
            let password = "";
            for (let i = 0; i < length; i++) {
                const randomIndex = Math.floor(Math.random() * charset.length);
                password += charset.charAt(randomIndex);
            }
            return password;
        }

        $("#role").select2({
            dropdownParent: $('#modal_form_vertical')
        });


        $("#building_id").select2({
            dropdownParent: $('#modal_form_vertical')
        });


        $("#info_table").DataTable({
            processing: true,
            "order": [[0, "desc"]],
            serverSide: true,
            ajax: {
                url: "{{route('admin.data')}}"
            },
            columns: [
                {
                    data: "id",
                    name: "id"
                },
                {
                    data: "name",
                    name: "name",
                    "class": "text-center"
                },
                {
                    data: "email",
                    name: "email",
                    "class": "text-center"
                },
                {
                    data: "phone",
                    name: "phone",
                    "class": "text-center"
                },
                {
                    data: "role",
                    name: "role",
                    "class": "text-center"

                },
                {
                    data: "checkbox",
                    name: "checkbox",
                    "class": "text-center"

                },
                {
                    data: "action",
                    name: "action",
                    "class": "text-center"
                }
            ]
        });
        $(document).on("click", "#edit", function () {
            var id = $(this).data('id');
            $.ajax({
                url: "{{url('/admin')}}/" + id+'/edit',
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $(".update_section").html(data.html);
                    $("#modal_form_vertical_edit").modal("show");
                }
            });
        })
    })

</script>
