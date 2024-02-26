<?php

use App\Exports\ModelExporter;
use App\Helpers\Message;
use App\Models\Building;
use App\Models\EmployeeCategory;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

// For Image Checkboxes

function splitFullName($fullName)
{
    $names = explode(' ', $fullName);

    // Check if the full name has at least three names
    if (count($names) < 1) {
        return 'The provided name does not have three parts.';
    }

    $firstName = $names[0];
    $middleName = $names[1] ?? '';
    $lastName = $names[2] ?? '';

    return [
        'first_name' => $firstName,
        'middle_name' => $middleName,
        'last_name' => $lastName,
    ];
}

if (! function_exists('generate_dashboard_styles')) {
    /**
     * Generate dashboard styles based on user's brand settings.
     */
    function generate_dashboard_styles(): string
    {
        $user = auth()->user();

        //        if ($user->hasRole('Super Admin')) {
        //            return ''; // Return empty string for super admins
        //        }

        $settings = $user?->building?->settings;

        $styles = '';

        $sidebarColor = $settings->sidebar_color ?? '';
        $activeColor = $settings->active_color ?? '';
        $headerColor = $settings->header_color ?? '';

        // Check for sidebar and text colors
        if ($sidebarColor) {
            $styles .= "
            .sidebar-main {
                background-color: {$sidebarColor};
            }";
        }

        // Check for active color
        if ($activeColor) {
            $styles .= "
            .active {
                background-color: {$activeColor};
            }";
        }
        if ($headerColor) {
            $styles .= "
            .navbar-dark {
                color: #fff;
                background-color: {$headerColor};
            }";
        }

        return $styles;
    }
}

if (! function_exists('getDashboardDesign')) {

    function getDashboardDesign($attribute)
    {
        $user = auth()->user();

        // Ensure the user is authenticated and the building settings are loaded
        if ($user && $user->building && $user->building->settings) {
            return $user->building->settings->$attribute ?? null;
        }

        return null;
    }
}
if (! function_exists('formatRoleName')) {

    function formatRoleName($role)
    {
        switch ($role->name) {
            case 'camp_hr':
                return 'Camp HR';
            case 'camp_chief':
                return 'Camp Chief';
            case 'office_hr':
                return 'Office HR';
            default:
                return $role->name;
        }
    }
}

if (! function_exists('logSalaryChange')) {
    function logSalaryChange($employeeId, $buildingId, $oldSalary, $newSalary, $date = null)
    {
        $data = [
            'employee_id' => $employeeId,
            'building_id' => $buildingId,
            'old_salary' => $oldSalary,
            'new_salary' => $newSalary,
            'date' => $date ?? now(),
            'created_by' => auth()->id(), // Assuming the user is authenticated.
        ];

        return \App\Models\EmployeesChangedSalary::create($data);
    }
}
if (! function_exists('get_setting')) {
    /**
     * Retrieve a setting value by its type.
     *
     * @param  string  $type The type of the setting to retrieve.
     * @return mixed|null The value of the setting or null if not found.
     */
    function get_setting(string $type)
    {
        // Retrieve the setting by its type.
        $setting = \App\Models\Settings::where('type', $type)->first();

        return $setting ? json_decode($setting->value, true) : null;
    }
}

if (! function_exists('add_notification')) {
    /**
     * Add a new notification.
     *
     * @param  int  $role The role of the user to be sent to.
     * @param  string  $title The title of the notification.
     * @param  string  $message The message/content of the notification.
     * @param  string  $type The type of notification: info, warning, success, etc.
     * @param  string|null  $url Optional URL for redirection.
     * @return Notification The created notification instance.
     */
    function add_notification(string $role, string $title, string $message, string $type = 'info', string $url = null, int $building_id = 1): App\Models\Notifications
    {
        return \App\Models\Notifications::create([
            'role' => $role,
            'title' => $title,
            'message' => $message,
            'building_id' => $building_id,
            'type' => $type,
            'url' => $url,
            'created_by' => auth()->user()->id,
        ]);
    }
}

if (! function_exists('jsonResponse')) {
    function jsonResponse(
        int $status = Response::HTTP_OK,
        string $message = '',
        object|array $data = null,
        object|array $extraData = null,
        array $errors = [],
        array $meta = []
    ): Illuminate\Contracts\Foundation\Application|Illuminate\Contracts\Routing\ResponseFactory|Illuminate\Foundation\Application|Illuminate\Http\Response {
        $content = [];
        if ($message) {
            $content['message'] = $message;
        }
        if ($data) {
            $content['data'] = $data;
        }
        if ($extraData) {
            $content['extraData'] = $extraData;
        }
        if ($errors) {
            $content['errors'] = $errors;
        }
        if ($meta) {
            $content['meta'] = $meta;
        }

        return ! empty($content) ? response($content, $status) : response(status: $status);
    }
}

// For Active Checkboxes
function generateCheckbox($data, $routeName)
{
    if ($data->active == 1) {
        $status = 'Active';
        $status_check = 'checked';
        $status_label = 'bg-success';
    } else {
        $status = 'Suspended';
        $status_check = '';
        $status_label = 'bg-danger';
    }

    $checkbox = '<label class="form-check mb-2">
        <input type="checkbox" class="form-check-input form-check-input-success checkbox_change_status" '.$status_check.' data-route="'.route($routeName, [$data->id]).'">
        <span class="badge '.$status_label.'">'.$status.'</span>
    </label>';

    return $checkbox;
} // End Function

function generateImage($data)
{
    return '<img src="'.uploaded_asset($data->image).'" width="100" height="70">';
} // End Function

// For Action Buttons
function generateActionButtons($data, $actions, $permissions)
{
    $button = '';
    if (\Auth::user()->canAny($permissions)) {
        $button .= '<div class="d-inline-flex">
            <div class="dropdown">
                <a href="#" class="text-body" data-bs-toggle="dropdown">
                    <i class="ph-list"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end">';

        foreach ($actions as $action) {
            if (isset($action['id'], $action['icon'], $action['text'], $action['routeName'])) {
                $href = isset($action['is_href']) ? route($action['routeName'], [$data->id, isset($action['param']) ? $action['param'] : '']) : '#';

                $extraAttributes = '';
                if (isset($action['extra_attributes'])) {
                    foreach ($action['extra_attributes'] as $attrKey => $attrValue) {
                        $extraAttributes .= ' '.$attrKey.'="'.$attrValue.'"';
                    }
                }

                if (isset($action['permission']) && \Auth::user()->can($action['permission'])) {
                    $button .= '
            <a href="'.$href.'" id="'.$action['id'].'" data-id="'.$data->id.'" data-route="'.route($action['routeName'], [$data->id]).'" '.$extraAttributes.' class="dropdown-item" >
                <i class="'.$action['icon'].' me-2"></i>
                '.$action['text'].'
            </a>';
                }

            }
        }

        $button .= '
                </div>
            </div>
        </div>';
    }

    return $button;
}

// For Action Buttons
function getRoles()
{
    return Role::where('active', 1)->get();
} // End Function

// For Action Buttons
function getBuildings()
{
    return Building::where('active', 1)->checkRole()->get();
} // End Function

function getEmployeeCategory()
{
    return EmployeeCategory::where('active', 1)->get();
} // End Function

function getTypeBuilding($type)
{
    $types = [
        '0' => 'Office',
        '1' => 'Campus',
        '2' => 'Warehouse',
    ];

    return $types[$type];
} // End Function

function getAttendanceColor($type, $mode = 'label')
{
    $colors = [
        'present' => 'bg-success',
        'absence' => 'bg-danger',
        'halfday' => 'bg-warning',
        'training' => 'bg-primary',
        'standby' => 'bg-yellow text-black',
    ];

    if ($mode == 'label') {
        return isset($colors[$type]) ? "<span class='badge {$colors[$type]}'>".ucfirst($type).'</span>' : ucfirst($type);
    } else {
        return $colors[$type] ?? 'black';
    }
}

function getBuildingEmployeesCount($building_id)
{
    return \App\Models\User::where('building_id', $building_id)->count();
} // End Function
function getBuildingPayrollsCount($building_id)
{
    return \App\Models\Payroll::where('building_id', $building_id)->count();
} // End Function

function export($model, $resource): BinaryFileResponse
{
    if (! count($model)) {
        throw ValidationException::withMessages(['message' => Message::NO_DATA_TO_EXPORT]);
    }

    if ($resource === null) {
        return Excel::download(
            export: new ModelExporter(collect($model)->toBase(), array_keys($model[0])),
            fileName: 'AttendanceReport_'.date('Y-m-d_H-i-s').'.'.request()->export_type
        );
    }

    return Excel::download(
        export: new ModelExporter($resource::collection($model), getExportHeaders($resource, $model[0])),
        fileName: getExportFileName($resource)
    );
}

if (! function_exists('getExportFileName')) {
    function getExportFileName($resource): string
    {
        $name = str_replace('Resource', '', (new ReflectionClass($resource))->getShortName());

        return date('Y-m-d_H-i-s')."_$name.csv";
    }

}

if (! function_exists('getExportHeaders')) {
    function getExportHeaders($resource, $model): array
    {
        $resourceObject = new $resource($model);

        if ($resourceObject instanceof JsonSerializable) {
            $serializedData = $resourceObject->jsonSerialize();

            if (! is_array($serializedData)) {
                throw ValidationException::withMessages(['message' => Message::MUST_RETURN_AN_ARRAY]);
            }

            return array_map(function ($key) {
                return ucwords(str_replace('_', ' ', (string) $key));
            }, array_keys($serializedData));
        } else {
            throw ValidationException::withMessages(['message' => Message::MUST_IMPLEMENT_JSON_SERIALIZE]);
        }
    }
}

if (! function_exists('OfficeRoleCheck')) {
    function OfficeRoleCheck(): bool
    {
        if (Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('office_hr')) {
            return true;
        } else {
            return false;
        }
    }
}

if (! function_exists('getRoleName')) {
    function getRoleName(): string
    {
        return \auth()->user()->roles->first()->name;
    }
}

if (! function_exists('usd_price')) {
    function usd_price($price)
    {
        return number_format($price, 2, '.', ',').' '.trans('translate.usd_symbol');
    }
}

if (! function_exists('iqd_price')) {
    function iqd_price($price)
    {
        if (! is_float($price)) {
            // Attempt to convert non-float values to float
            $price = floatval($price);
            if (! is_float($price)) {
                // Handle error: $price cannot be converted to a float
                return '';
            }
        }

        return number_format($price, 0, '.', ',').' '.trans('translate.iqd_symbol');
    }
}
