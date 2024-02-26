<?php

namespace App\Traits;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    public string $storeRequest = 'storeRequest';

    public string $updateRequest = 'updateRequest';

    public string $indexRequest = 'indexRequest';

    public string $showRequest = 'showRequest';

    public string $destroyRequest = 'destroyRequest';

    protected function indexResponse($message = '', $data = [], $extraData = [], $meta = []): Application|Response|ResponseFactory
    {
        return jsonResponse(
            message: $message,
            data: $data,
            extraData: $extraData,
            meta: $meta
        );
    }

    protected function listResponse($message = '', $data = []): Application|Response|ResponseFactory
    {
        return jsonResponse(message: $message, data: $data);
    }

    protected function showResponse($message = '', $data = []): Application|Response|ResponseFactory
    {
        return jsonResponse(message: $message, data: $data);
    }

    protected function destroyResponse(
        $message = '',
        $data = [],
        $status = Response::HTTP_NO_CONTENT
    ): Application|Response|ResponseFactory {
        return jsonResponse(status: $status, message: $message, data: $data);
    }

    public function updateResponse(
        $message = '',
        $data = [],
        $status = Response::HTTP_OK
    ): Application|Response|ResponseFactory {
        return jsonResponse(status: $status, message: $message, data: $data);
    }

    public function storeResponse(
        $data = [],
        $message = '',
        $status = Response::HTTP_OK
    ): Application|Response|ResponseFactory {
        return jsonResponse(status: $status, message: $message, data: $data);
    }

    public function modelSorting($model, $sortDir, $sortBy)
    {
        $isNestedSort = str_contains($sortBy, '.');
        if (! $isNestedSort) {
            $model->orderBy($sortBy, $sortDir);
        }
        $model = $model->get();
        if ($isNestedSort) {
            $model = $sortDir == 'desc' ? $model->sortByDesc($sortBy)->values() : $model->sortBy($sortBy)->values();
        }

        return $model;
    }

    public function getPaginationMeta($model, $request): array
    {
        $total = $model->count();
        $perPage = $request->input('perPage', 10);
        $totalPages = (int) ceil($total / $perPage);
        $currentPage = $request->input('page', 1);
        $firstItem = $total > 0 ? ($currentPage - 1) * $perPage + 1 : null;
        $to = $total > 0 ? $firstItem + $perPage - 1 : null;
        $lastPage = max($totalPages, 1);

        return [
            'total' => $total,
            'totalPages' => $totalPages,
            'perPage' => (int) $perPage,
            'currentPage' => (int) $currentPage,
            'lastPage' => (int) $lastPage,
            'isLastPage' => $currentPage == $lastPage,
            'isFirstPage' => $currentPage == 1,
            'from' => (int) $firstItem,
            'to' => (int) $to > $total ? $total : $to,
        ];
    }

    public function limitAndOffset($query, $request)
    {
        $per_page = $request->input('perPage', 10);
        $page = $request->input('page', 0);
        $skip = $per_page * ($page - 1);

        return $query->skip($skip)->limit($per_page);
    }

    public function setFormRequestToTheRequest($model): void
    {
        if (request()->routeIs('*store')) {
            request()->request->set($this->storeRequest, $model->storeFormRequest);
        }
        if (request()->routeIs('*update')) {
            request()->request->set($this->updateRequest, $model->updateFormRequest);
        }
        if (request()->routeIs('*index')) {
            request()->request->set($this->indexRequest, $model->indexFormRequest);
        }
    }

    public function setShowFormRequestToTheRequest($model): void
    {
        if (request()->routeIs('*show')) {
            request()->request->set($this->showRequest, $model->showFormRequest);
        }
    }

    public function setDestroyFormRequestToTheRequest($model): void
    {
        if (request()->routeIs('*destroy')) {
            request()->request->set($this->destroyRequest, $model->destroyFormRequest);
        }
    }
}
