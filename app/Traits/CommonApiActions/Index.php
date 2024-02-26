<?php

namespace Modules\Admin\App\Traits\CommonApiActions;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Model;
use Knuckles\Scribe\Attributes\BodyParam;
use Modules\Admin\App\Actions\BaseActions\FetchModels;
use Modules\Admin\App\Http\Requests\BaseRequests\BaseActionsIndexRequest;
use Symfony\Component\HttpFoundation\Response;

trait Index
{
    protected Model $modelClass;

    #[BodyParam('page', 'integer', 'The page number of the fetched data.', required: false, example: 1)]
    #[BodyParam('perPage', 'integer', 'Display records per page.', required: false, example: 10)]
    #[BodyParam('search', required: false, example: '')]
    #[BodyParam('sortBy', 'string', 'Field to sort by.', required: false, example: 'name')]
    #[BodyParam('sortDir', 'string', 'Sort direction.', required: false, example: 'desc')]
    //    #[BodyParam("filter[]", "")]
    public function index(BaseActionsIndexRequest $request, FetchModels $action): Application|Response|ResponseFactory
    {
        return $action->handle($this->modelClass, $request);
    }
}
