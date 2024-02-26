


<!-- Vertical Edit form modal -->
<div id="modal_form_vertical_edit" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white border-0">
                <h6 class="modal-title">Edit Role</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form method="post" action="" class="form-validate-jquery main_form_edit" id="main_form_edit">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                        <label class="form-label">Role Name</label>
                        <input id="name" type="text" class="form-control" name="name" required  placeholder="Role name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Permission</label>
                        <select multiple="multiple" name="permissions[]" multiple class="form-control listbox-buttons-update">
                            <?php
                            $nameRole = \Illuminate\Support\Facades\DB::table('permissions')->get();
                            foreach ($nameRole as $name){
                                ?>
                            <option value="<?php echo $name->id ?>"><?php echo $name->name ?></option>
                            <?php } ?>

                        </select>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-dark submit_form">Submit form <i
                                class="icon-paperplane ms-2 send_icon"></i></button>
                    </div>
                </form>
            </div>


        </div>
    </div>
</div>
<!-- /vertical Edit form modal -->
