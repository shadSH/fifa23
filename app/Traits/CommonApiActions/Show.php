<?php

namespace Modules\Admin\App\Traits\CommonApiActions;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Model;
use Knuckles\Scribe\Attributes\UrlParam;
use Modules\Admin\App\Actions\BaseActions\ShowModel;
use Modules\Admin\App\Http\Requests\BaseRequests\BaseActionsShowRequest;
use Symfony\Component\HttpFoundation\Response;

trait Show
{
    protected Model $modelClass;

    #[UrlParam('id', 'integer', 'The ID of the required record to be displayed.', example: 1)]
    public function show(BaseActionsShowRequest $request, ShowModel $action): Response|Application|ResponseFactory
    {
        return $action->handle($this->modelClass, (int) $request->id);
    }
}
