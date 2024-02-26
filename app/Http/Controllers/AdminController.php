<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Models\Admin;
use App\Services\AdminService;
use App\Traits\CommonApiActions\Delete;
use App\Traits\CommonApiActions\StatusChange;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    use Delete , StatusChange;

    public function __construct(protected AdminService $userService, protected Admin $user)
    {
        $this->model = new Admin();
        $this->deletePermission = 'delete_user_management';
        $this->updatePermission = 'update_user_management';
    }

    public function index()
    {
        $this->authorize('view_user_management');
        $data = $this->getCommonData();

        return view('admin.index', $data);
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            return $this->prepareDataTables();
        }
    }

    public function store(StoreAdminRequest $request): Application|ResponseFactory|Response
    {
        $this->authorize('add_user_management');
        $this->userService->create($request->validated());

        return jsonResponse(message: 'Admin created successfully');
    }

    public function edit(Admin $user)
    {
        $this->authorize($this->updatePermission);
        $data = $this->getCommonData();
        $data['user'] = $user;
        $html = view_template_part('admin.update', $data);

        return Response()->json(['html' => $html]);
    }

    public function update(UpdateAdminRequest $request, Admin $user): Application|ResponseFactory|Response
    {
        $this->authorize($this->updatePermission);
        $this->userService->update($user, $request->validated());

        return jsonResponse(message: 'Admin Updated successfully');
    }

    public function get_users(Request $request)
    {
        $users = $this->user->filterAdmins($request->all())->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'text' => $user->userDetail->name_en,
                ];
            });

        return response()->json($users);
    }

    private function getCommonData(): array
    {
        return [
            'roles' => getRoles(),
        ];
    }

    private function prepareDataTables()
    {

        $users = $this->user->query();

        return Datatables::of($users)->editColumn('checkbox', function ($data) {
            return generateCheckbox($data, 'admin.status_change');
        })->editColumn('role', function ($data) {
            return $data->getRoleNames()->first() ?? 'N/A';
        })->editColumn('full_name', function ($data) {
            return $data->full_name;
        })->addColumn('action', function ($data) {
            $actions = [
                [
                    'id' => 'edit',
                    'icon' => 'fa fa-edit',
                    'text' => 'Edit',
                    'routeName' => 'admin.edit',
                    'permission' => 'update_user_management',
                ],
                [
                    'id' => 'delete',
                    'icon' => 'fa fa-trash',
                    'text' => 'Delete',
                    'routeName' => 'admin.destroy',
                    'permission' => 'delete_user_management',
                ],
                //                [
                //                    'id' => 'update_password',
                //                    'icon' => 'fa fa-sync',
                //                    'text' => 'Update Password',
                //                    'routeName' => 'admin.update_password',
                //                    'permission' => 'update_password',
                //                ],
            ];

            $permissions = ['update_user_management', 'delete_user_management'];

            return generateActionButtons($data, $actions, $permissions);
        })
            ->addIndexColumn()
            ->rawColumns(['action', 'active', 'checkbox'])
            ->make(true);
    }

    public function update_password(Admin $user)
    {
        $this->authorize('update_password');

        $getRandomPassword = $this->generateRandomPassword();
        $user->update(['password' => bcrypt($getRandomPassword)]);

        return jsonResponse(message: 'Password Updated successfully', data: ['password' => $getRandomPassword]);

    }

    private function generateRandomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = [];
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 14; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        return implode($pass);
    }
}
