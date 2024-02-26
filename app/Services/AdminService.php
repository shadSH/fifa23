<?php

namespace App\Services;

use App\Models\Admin;
use App\Traits\FetchModel;
use Illuminate\Support\Facades\DB;

class AdminService
{
    use FetchModel;

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $data['user']['password'] = bcrypt($data['user']['password']);

            $user = Admin::create($data['user']);

            $user->assignRole($data['user']['role_id']);

            DB::commit();

            return $user;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update(Admin $user, array $data)
    {
        DB::beginTransaction();

        try {
            $user->update($data['user']);
            $user->syncRoles($data['user']['role_id']);

            DB::commit();

            return $user;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function getUserByRole($building_id, string $roleName)
    {
        $user = $this->getList(
            model: new Admin(),
            filters: ['building_id' => $building_id],
            relationFilters: ['roles' => ['name' => $roleName]]
        );

        return $user?->full_name;
    }

    public function getUsers(array $filters = [], array $relations = [], array $relationFilters = [], $isList = false)
    {
        $query = Admin::query();

        $query->with($relations);
        // Apply main filters
        foreach ($filters as $key => $value) {
            if ($key === 'role') {
                $query->role($value);
            } else {
                $query->where($key, $value);
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

        return ($isList == true) ? $query->get() : $query->first();
    }
}
