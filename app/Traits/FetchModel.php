<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait FetchModel
{
    public function getList(Model $model, array $filters = [], array $relations = [], array $relationFilters = [], $isList = false, $isJson = false, $extraFilters = [])
    {
        $query = $model::query();

        $query->with($relations);
        // Apply main filters

        foreach ($filters as $key => $value) {
            if ($value !== null && $value !== '') {
                $query->where($key, $value);
            }

        }
        foreach ($extraFilters as $filter) {
            if ($filter !== null && $filter !== '') {
                $query->$filter();
            }
        }

        // Apply relation filters
        foreach ($relationFilters as $relation => $conditions) {
            $query->whereHas($relation, function ($query) use ($conditions) {
                foreach ($conditions as $field => $value) {
                    $query->where($field, $value);
                }
            });
        }

        if ($isJson) {
            return $query;
        }

        return ($isList) ? $query->get() : $query->first();
    }
}
