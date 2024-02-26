<?php

namespace App\Traits\CommonApiActions;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

trait Store
{
    use ApiResponse;

    public $model;

    public function store(): Application|Response|ResponseFactory
    {
        return DB::transaction(function () {

            // Assume storeFormRequest holds the class name of the form request
            $formRequestClass = $this->model->storeFormRequest;

            // Ensure the class exists and can be instantiated
            if (class_exists($formRequestClass)) {
                $formRequest = app($formRequestClass);

                if (method_exists($formRequest, 'validated')) {
                    $validatedData = $formRequest->validated();

                    $this->model = $this->model->create($validatedData);

                    return $this->storeResponse(message: $this->storeMessage());
                } else {
                    throw new \Exception("The class {$formRequestClass} does not have a validated method.");
                }
            } else {
                throw new \Exception("The class {$formRequestClass} does not exist.");
            }

        });
    }

    public function storeMessage(): string
    {
        $modelName = class_basename($this->model);

        return "The {$modelName} has been created.";
    }
}
