<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class CrudGeneratorController extends Controller
{
    //

    public function index()
    {

        return view('crud_generator.index');
    }

    public function show_fields()
    {
        $html = view_template_part('crud_generator.show');

        return response()->json([
            'html' => $html,
        ]);
    }

    public function generate(Request $request)
    {

        $request->validate([
            'database_name' => 'required|array',
            'database_name.*' => 'required',
            'filed_type' => 'required|array',
            'filed_type.*' => 'required',
        ]);

        $model_name = $request->model_name;
        $menu_title = $request->menu_title;

        $field_type = [];
        $database_name = [];
        $fields = [];
        $validations = [];

        for ($i = 0; $i < count($request->filed_type); $i++) {
            array_push($field_type, $request->filed_type[$i]);
            array_push($fields, $request->database_name[$i].'#'.$request->filed_type[$i]);
            if (isset($request->is_required[$i])) {
                if ($request->is_required[$i] == 'on') {

                    $validation = $this->merge_validations($request->database_name[$i], 'required', (isset($request->is_show[$i]) ? 'show' : ''));
                    array_push($validations, $validation);

                }

            }

        }

        for ($i = 0; $i < count($request->database_name); $i++) {
            array_push($database_name, $request->database_name[$i]);
        }

        $field_type = implode(',', $field_type);
        $database_name = implode(',', $database_name);
        $fields = implode(';', $fields);
        $validations = implode(';', $validations);

        $result = Artisan::call('technobase:all', [
            'name' => $model_name,
            '--crud-model' => $database_name,
            '--fields' => $fields,
            '--validations' => $validations,
        ]);

        $output = Artisan::output();
        Artisan::call('migrate');

        //        $result = $this->call('technobase:all', ['name' => $model_name, '--crud-model'=>$field_type]);

        return response()->json([
            'result' => $result,
            'output' => $output,
        ]);

    }

    private function merge_validations($name, $is_required, $show = '')
    {
        if ($show != '') {
            $merge = $name.'#'.$is_required.'#'.$show;
        } else {
            $merge = $name.'#'.$is_required;
        }

        return $merge;
    }
}
