<?php

namespace App\Traits\CommonApiActions;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

trait Update
{
    use ApiResponse;

    public $model;

    public function update(): Application|Response|ResponseFactory
    {
        $id = request()->route()->parameters();
        $id = array_values($id)[0];

        return DB::transaction(function () use ($id) {

            // Fetch the model by ID
            $modelInstance = $this->model->findOrFail($id);

            // Assume updateFormRequest holds the class name of the form request
            $formRequestClass = $this->model->updateFormRequest;

            // Ensure the class exists and can be instantiated
            if (class_exists($formRequestClass)) {
                $formRequest = app($formRequestClass);

                if (method_exists($formRequest, 'validated')) {
                    $validatedData = $formRequest->validated();
                    $modelInstance->update($validatedData);

                    return $this->updateResponse(message: $this->updateMessage());
                } else {
                    throw new \Exception("The class {$formRequestClass} does not have a validated method.");
                }
            } else {
                throw new \Exception("The class {$formRequestClass} does not exist.");
            }

        });
    }

    public function updateMessage(): string
    {
        $modelName = class_basename($this->model);

        return "The {$modelName} has been updated.";
    }
}
