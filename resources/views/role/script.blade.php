

<script src="{{asset('global_assets/js/vendor/forms/inputs/dual_listbox.min.js')}}"></script>

<script>
    $(document).ready(function () {
        const listboxButtonsElement = document.querySelector(".listbox-buttons");
        const listboxButtons = new DualListbox(listboxButtonsElement, {
            addButtonText: "<i class='ph-caret-right'></i>",
            removeButtonText: "<i class='ph-caret-left'></i>",
            addAllButtonText: "<i class='ph-caret-double-right'></i>",
            removeAllButtonText: "<i class='ph-caret-double-left'></i>"
        });

        const listboxButtonsElementUpdate = document.querySelector(".listbox-buttons-update");
        const listboxButtonsUpdate = new DualListbox(listboxButtonsElementUpdate, {
            addButtonText: "<i class='ph-caret-right'></i>",
            removeButtonText: "<i class='ph-caret-left'></i>",
            addAllButtonText: "<i class='ph-caret-double-right'></i>",
            removeAllButtonText: "<i class='ph-caret-double-left'></i>"
        });
        $("#info_table").DataTable({
            processing: true,
            "order": [[0, "desc"]],
            serverSide: true,
            ajax: {
                url: "{{route('role.data')}}"
            },
            columns: [
                {
                    data: "id",
                    name: "id"
                },
                {
                    data: "name",
                    name: "name",
                },
                {
                    data: "permissions",
                    name: "permissions",
                },
                {
                    data: "checkbox",
                    name: "checkbox",
                },
                {
                    data: "created_at",
                    name: "created_at"
                },
                {
                    data: "action",
                    name: "action"
                }
            ]
        });
        $(document).on("click", "#edit", function () {
            var id = $(this).data('id');
            $.ajax({
                url: "{{url('/role')}}/" + id+'/edit',
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $("#id").val(data.data.id);
                    $("#name").val(data.data.name);
                    $('#main_form_edit').attr('action', data.route);
                    var ident = data.permissions;

                    // ident = ident.split(",");
                    // console.log(data.data.permissions);
                    $.each(ident, function (key, value) {

                        $('[name="permissions[]"] option[value="' + value.id + '"]').prop("selected", true);

                    });
                    // $('[name="permissions[]"]').DualListbox('refresh', true);
                    listboxButtonsUpdate.addEventListener("removed", function (event) {
                        console.log(event);
                        console.log(event.removedElement);
                    });
                    $("#modal_form_vertical_edit").modal("show");
                }
            });
        })
    })

</script>
