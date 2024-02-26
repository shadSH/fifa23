<?php

namespace App\Http\Controllers;

use App\DataTables\City\CityDataTable;
use App\Models\City;
use App\Traits\ApiResponse;
use App\Traits\CommonApiActions\Delete;
use App\Traits\CommonApiActions\StatusChange;
use App\Traits\CommonApiActions\Store;
use App\Traits\CommonApiActions\Update;
use Illuminate\Http\Request;

class CityController extends Controller
{
    use StatusChange , Delete  , Store , Update , ApiResponse;

    public function __construct()
    {
        $this->model = new City();
        $this->setFormRequestToTheRequest($this->model);
    }

    public function index(Request $request, CityDataTable $dataTable)
    {
        $this->authorize('view_city');

        if ($request->ajax()) {
            return $dataTable->render('city.index');
        }

        return view('city.index');
    }

    public function edit(City $city)
    {
        $this->authorize($this->updatePermission);
        $html = view_template_part('city.update', compact('city'));

        return Response()->json(['html' => $html]);
    }
}
