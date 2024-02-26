<?php

namespace Modules\Admin\App\Traits\CommonApiActions;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\App\Actions\BaseActions\LookupListOfModels;
use Symfony\Component\HttpFoundation\Response;

trait ListAction
{
    protected Model $modelClass;

    public function list(LookupListOfModels $action): Application|Response|ResponseFactory
    {
        return $action->handle($this->modelClass);
    }
}
