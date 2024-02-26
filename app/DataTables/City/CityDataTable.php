<?php

namespace App\DataTables\City;

use App\Models\City;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;

class CityDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable()
    {

        return datatables()
            ->eloquent($this->query())
            ->editColumn('name', function ($data) {
                return $data->name;
            })
            ->editColumn('created_by', function ($data) {
                return $data?->user?->full_name;
            })
            ->editColumn('created_at', function ($data) {
                $createdAt = Carbon::parse($data->created_at);

                return $createdAt->format('Y-m-d h:i:s');
            })
            ->addColumn('checkbox', function ($data) {
                return generateCheckbox($data, 'city.status_change');
            })
            ->addColumn('action', function ($data) {
                $actions = [
                    [
                        'id' => 'edit',
                        'icon' => 'fa fa-edit',
                        'text' => 'Edit',
                        'routeName' => 'city.edit',
                        'permission' => 'update_city',
                    ],
                    [
                        'id' => 'delete',
                        'icon' => 'fa fa-trash',
                        'text' => 'Delete',
                        'routeName' => 'city.destroy',
                        'permission' => 'delete_city',
                    ],
                ];
                // generateActionButtons is a custom function you need to define to generate the action buttons based on permissions
                return generateActionButtons($data, $actions, ['update-city', 'delete-city']);
            })
            ->rawColumns(['action', 'checkbox']);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return City::query();
    }

    // ... other functions like html(), columns(), filename() etc.
}
