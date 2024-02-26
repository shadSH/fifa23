<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view_role');

        return view('role.index');
    }

    public function data(Request $request)
    {
        $this->authorize('view_role');
        if ($request->ajax()) {
            $roles = Role::where('id', '<>', 1)->get();

            return Datatables::of($roles)
                ->editColumn('checkbox', function ($data) {

                    if ($data->active == 1) {
                        $status = 'Active';
                        $status_check = 'checked';
                        $status_label = '';
                    } else {
                        $status = 'Suspended';
                        $status_check = '';
                        $status_label = 'text-danger';
                    }

                    $checkbox = '<label class="form-check mb-2">
															<input type="checkbox" class="form-check-input form-check-input-secondary checkbox_change_status " '.$status_check.' data-route="'.route('role.status_change', [$data->id]).'">
															<span class="form-check-label '.$status_label.'">'.$status.'</span>
														</label>';

                    return $checkbox;
                })
                ->editColumn('created_by', function ($data) {
                    //                    return $data->User->name;
                })->editColumn('created_at', function ($data) {
                    $createdAt = Carbon::parse($data->created_at);

                    return $createdAt->format('Y-m-d h:i:s');
                })->editColumn('permissions', function ($data) {

                    $span = '';
                    $pemission = DB::table('role_has_permissions')
                        ->select('permissions.name as per_name')
                        ->join('permissions', 'permissions.id', 'role_has_permissions.permission_id')
                        ->where('role_id', $data->id)
                        ->get();

                    foreach ($pemission as $per) {
                        $span .= '<span class="badge bg-success me-2">'.$per->per_name.' </span>';
                    }

                    return $span;

                })
                ->addColumn('action', function ($data) {
                    $button = '';
                    if (\Auth::user()->can('update_role') || \Auth::user()->can('delete_role')) {
                        $button .= '<div class="d-inline-flex">
											<div class="dropdown">
												<a href="#" class="text-body" data-bs-toggle="dropdown">
													<i class="ph-list"></i>
												</a>

												<div class="dropdown-menu dropdown-menu-end"> ';

                        $button .= '
													<a href="#" id="edit" data-id="'.$data->id.'" class="dropdown-item">
														<i class="fa fa-edit me-2"></i>
														Edit
													</a>';
                        $button .= '
													<a href="#" id="delete" data-id="'.$data->id.'" data-route="'.route('role.destroy', [$data->id]).'" class="dropdown-item">
														<i class="fa fa-trash me-2"></i>
														Delete
													</a>
													';
                        $button .= '
												</div>
											</div>
										</div>';
                    }

                    return $button;

                })
                ->addIndexColumn()
                ->rawColumns(['action', 'checkbox', 'permissions'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->authorize('add_role');
        $validatedData = $request->validate([
            'permissions' => 'required',
            'name' => ['required', 'unique:roles'],
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        if ($role) {
            return response()->json([
                'status' => 'success',
                'message' => 'Role Created Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'Please Try Again !',
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Role $role)
    {
        $this->authorize('update_role');
        $pemission = DB::table('role_has_permissions')
            ->select('permissions.name as per_name', 'permissions.id')
            ->join('permissions', 'permissions.id', 'role_has_permissions.permission_id')
            ->where('role_id', $role->id)
            ->get();

        return response()->json([
            'status' => true,
            'route' => ''.route('role.update', [$role->id]).'',
            'data' => $role,
            'permissions' => $pemission,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Role $role)
    {

        $this->authorize('update_role');
        $validatedData = $request->validate([
            'id' => 'required',
            'permissions' => 'required',
            'name' => ['required', Rule::unique('roles')->ignore($role->id)],
        ]);
        $role->name = $request->name;
        $role->syncPermissions($request->permissions);
        if ($role->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Brand Updated Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'Please Try Again !',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete_role');
        $role->delete();

        return response()->json([
            'status' => true,
            'message' => 'Record deleted successfully!',
        ]);

    }

    public function status_change(Role $role)
    {
        $this->authorize('update_role');
        if ($role->active == 1) {
            $role->active = 0;
        } else {
            $role->active = 1;
        }
        $role->save();

        return response()->json([
            'status' => true,
            'message' => 'Status Change successfully!',
        ]);
    }
}
