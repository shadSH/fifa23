<?php

namespace App\Traits\CommonApiActions;

trait StatusChange
{
    public $model;

    public $updatePermission;

    public function status_change(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
    {
        $this->authorize($this->updatePermission);
        $id = request()->route()->parameters();
        $id = array_values($id)[0];
        $post = $this->model->find($id);

        if ($post->active == 1) {
            $post->active = 0;
        } else {
            $post->active = 1;
        }
        $post->save();

        return jsonResponse(message: 'Status Change successfully!');
    }
}
