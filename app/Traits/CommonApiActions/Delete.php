<?php

namespace App\Traits\CommonApiActions;

trait Delete
{
    public $model;

    public $deletePermission;

    public function destroy()
    {
        $this->authorize($this->deletePermission);
        $id = request()->route()->parameters();
        $id = array_values($id)[0];
        $this->model->find($id)->delete();

        return jsonResponse(message: 'Deleted Successfully Update');
    }
}
