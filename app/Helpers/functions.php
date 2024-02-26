<?php

use App\Models\Discount;
use Carbon\Carbon;

if (! function_exists('str_plural')) {
    function str_plural($value, $count = 2)
    {
        return Illuminate\Support\Str::plural($value, $count);
    }
}

if (! function_exists('snake_case')) {
    function snake_case($value, $delimiter = '_')
    {
        return Illuminate\Support\Str::snake($value, $delimiter);
    }
}

function generateRandomString($length = 15)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}

function no_data($title = '', $desc = '', $class = null)
{
    $title = $title ? $title : 'nothing_here';
    $desc = $desc ? $desc : 'nothing_here_desc';
    $class = $class ? $class : 'my-4 pb-4';
    $no_data_img = asset('img/no-data.png');

    $output = " <div class='no-data-screen-wrap text-center {$class} '>
            <img src='{$no_data_img}' style='max-height: 250px; width: auto' />
            <h3 class='no-data-title'>{$title}</h3>
            <h5 class='no-data-subtitle'>{$desc}</h5>
        </div>";

    return $output;
}

if (! function_exists('getBaseURL')) {
    function getBaseURL()
    {
        $root = '//'.$_SERVER['HTTP_HOST'];
        $root .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

        return $root;
    }
}

if (! function_exists('getFileBaseURL')) {
    function getFileBaseURL()
    {
        if (env('FILESYSTEM_DRIVER') == 's3') {
            return env('AWS_URL').'/';
        } else {
            return getBaseURL();
        }
    }
}
//filter products based on vendor activation system

if (! function_exists('pageJsonData')) {
    function pageJsonData()
    {
        $data = [
            'home_url' => route('main'),
            'asset_url' => asset('assets'),
            'csrf_token' => csrf_token(),
            'is_logged_in' => auth()->check(),
            'dashboard' => route('home'),
        ];

        $routeLists = \Illuminate\Support\Facades\Route::getRoutes();

        $routes = [];
        foreach ($routeLists as $route) {
            $routes[$route->getName()] = $data['home_url'].'/'.$route->uri;
        }
        $data['routes'] = $routes;

        return apply_filters('page_json_data', $data);
    }
}
function apply_filters($tag, $value)
{
    global $teachify_filter, $teachify_current_filter;

    $args = func_get_args();

    // Do 'all' actions first.
    if (isset($teachify_filter['all'])) {
        $teachify_current_filter[] = $tag;
        _teachify_call_all_hook($args);
    }

    if (! isset($teachify_filter[$tag])) {
        if (isset($teachify_filter['all'])) {
            array_pop($teachify_current_filter);
        }

        return $value;
    }

    if (! isset($teachify_filter['all'])) {
        $teachify_current_filter[] = $tag;
    }

    // Don't pass the tag name to TeachifyHook.
    array_shift($args);

    $filtered = $teachify_filter[$tag]->apply_filters($value, $args);

    array_pop($teachify_current_filter);

    return $filtered;
}

if (! function_exists('view_template_part')) {
    function view_template_part($view = null, $data = [], $mergeData = [])
    {
        return view()->make($view, $data, $mergeData)->render();
    }
}

if (! function_exists('save_mail')) {
    function save_mail($from, $to, $subject, $message)
    {
        $mail = new \App\Models\ContactUsSent;
        $mail->from = $from;
        $mail->to = $to;
        $mail->subject = $subject;
        $mail->message = $message;
        $mail->created_at = Carbon::now();
        if ($mail->save()) {
            return true;
        } else {
            return false;
        }
    }
}

function array_get($array, $key, $default = null)
{
    return Arr::get($array, $key, $default);
}

if (! function_exists('selected')) {
    function selected($selected, $current = true, $echo = true)
    {
        return __checked_selected_helper($selected, $current, $echo, 'selected');
    }
}
if (! function_exists('__checked_selected_helper')) {
    function __checked_selected_helper($helper, $current, $echo, $type)
    {
        if ((string) $helper === (string) $current) {
            $result = " $type='$type'";
        } else {
            $result = '';
        }

        if ($echo) {
            echo $result;
        }

        return $result;
    }
}
if (! function_exists('my_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function my_asset($path, $secure = null)
    {
        if (env('FILESYSTEM_DRIVER') == 's3') {
            return Storage::disk('s3')->url($path);
        } else {
            return app('url')->asset('/'.$path, $secure);
        }
    }
}

if (! function_exists('uploaded_asset')) {
    function uploaded_asset($id)
    {
        if (($asset = \App\Models\Upload::find($id)) != null) {

            $link = $asset->external_link == null ? my_asset($asset->file_name) : $asset->external_link;

            return $link;
        }

        return null;
    }
}

if (! function_exists('get_images_path')) {
    function get_images_path($given_ids, $with_trashed = false)
    {
        $paths = [];
        foreach (explode(',', $given_ids) as $id) {
            $paths[] = uploaded_asset($id);
        }

        return $paths;
    }
}

//Shows Price on page based on low to high with discount

if (! function_exists('format_price')) {
    function format_price($price, $isMinimize = false)
    {

        $fomated_price = number_format($price);

        // Minimize the price
        if ($isMinimize) {
            $temp = number_format($price / 1000000000, '.', '');

            if ($temp >= 1) {
                $fomated_price = $temp.'B';
            } else {
                $temp = number_format($price / 1000000, '.', '');
                if ($temp >= 1) {
                    $fomated_price = $temp.'M';
                }
            }
        }

        return $fomated_price;

    }
}

if (! function_exists('media_upload_form')) {

    /**
     * @param  string  $input_name
     * @param  string  $btn_text
     * @param  string  $current_media_id
     */
    function media_upload_form($input_name = 'media_id', $btn_text = 'Upload Media', $btn_class = null, $current_media_id = '')
    {
        if (! $input_name) {
            $input_name = 'media_id';
        }
        $btn_class = $btn_class ? $btn_class : 'btn btn-primary';
        ?>
        <div class="image-wrap media-btn-wrap">
            <div class="saved-media-id">
                <?php if ($current_media_id) {
                    echo "<p class='text-info'>Uploaded ID: <strong>{$current_media_id}</strong></p>";
                } ?>
            </div>
            <a href="javascript:;" class="<?php echo $btn_class; ?>" data-toggle="filemanager">
                <?php echo $btn_text; ?>
            </a>
            <input type="hidden" name="<?php echo $input_name; ?>" class="image-input"
                   value="<?php echo $current_media_id; ?>">
        </div>
        <?php
    }
}
if (! function_exists('app_timezone')) {
    function app_timezone()
    {
        return config('app.timezone');
    }
}

function timezones()
{
    return timezonesToArray();
}

if (! function_exists('formatBytes')) {
    function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision).' '.$units[$pow];
    }
}
if (! function_exists('my_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function my_asset($path, $secure = null)
    {
        if (env('FILESYSTEM_DRIVER') == 's3') {
            return Storage::disk('s3')->url($path);
        } else {
            return app('url')->asset('public/'.$path, $secure);
        }
    }
}
if (! function_exists('public_path')) {
    /**
     * Get the path to the public folder.
     *
     * @param  string  $path
     * @return string
     */
    function public_path($path = '')
    {
        return app()->make('path.public').($path ? DIRECTORY_SEPARATOR.ltrim($path, DIRECTORY_SEPARATOR) : $path);
    }
}
function timezonesToArray()
{
    return [
        '(GMT-12:00) International Date Line West' => 'Pacific/Kwajalein',
        '(GMT-11:00) Midway Island' => 'Pacific/Midway',
        '(GMT-11:00) Samoa' => 'Pacific/Apia',
        '(GMT-10:00) Hawaii' => 'Pacific/Honolulu',
        '(GMT-09:00) Alaska' => 'America/Anchorage',
        '(GMT-08:00) Pacific Time (US & Canada)' => 'America/Los_Angeles',
        '(GMT-08:00) Tijuana' => 'America/Tijuana',
        '(GMT-07:00) Arizona' => 'America/Phoenix',
        '(GMT-07:00) Mountain Time (US & Canada)' => 'America/Denver',
        '(GMT-07:00) Chihuahua' => 'America/Chihuahua',
        '(GMT-07:00) La Paz' => 'America/Chihuahua',
        '(GMT-07:00) Mazatlan' => 'America/Mazatlan',
        '(GMT-06:00) Central Time (US & Canada)' => 'America/Chicago',
        '(GMT-06:00) Central America' => 'America/Managua',
        '(GMT-06:00) Guadalajara' => 'America/Mexico_City',
        '(GMT-06:00) Mexico City' => 'America/Mexico_City',
        '(GMT-06:00) Monterrey' => 'America/Monterrey',
        '(GMT-06:00) Saskatchewan' => 'America/Regina',
        '(GMT-05:00) Eastern Time (US & Canada)' => 'America/New_York',
        '(GMT-05:00) Indiana (East)' => 'America/Indiana/Indianapolis',
        '(GMT-05:00) Bogota' => 'America/Bogota',
        '(GMT-05:00) Lima' => 'America/Lima',
        '(GMT-05:00) Quito' => 'America/Bogota',
        '(GMT-04:00) Atlantic Time (Canada)' => 'America/Halifax',
        '(GMT-04:00) Caracas' => 'America/Caracas',
        '(GMT-04:00) La Paz' => 'America/La_Paz',
        '(GMT-04:00) Santiago' => 'America/Santiago',
        '(GMT-03:30) Newfoundland' => 'America/St_Johns',
        '(GMT-03:00) Brasilia' => 'America/Sao_Paulo',
        '(GMT-03:00) Buenos Aires' => 'America/Argentina/Buenos_Aires',
        '(GMT-03:00) Georgetown' => 'America/Argentina/Buenos_Aires',
        '(GMT-03:00) Greenland' => 'America/Godthab',
        '(GMT-02:00) Mid-Atlantic' => 'America/Noronha',
        '(GMT-01:00) Azores' => 'Atlantic/Azores',
        '(GMT-01:00) Cape Verde Is.' => 'Atlantic/Cape_Verde',
        '(GMT) Casablanca' => 'Africa/Casablanca',
        '(GMT) Dublin' => 'Europe/London',
        '(GMT) Edinburgh' => 'Europe/London',
        '(GMT) Lisbon' => 'Europe/Lisbon',
        '(GMT) London' => 'Europe/London',
        '(GMT) UTC' => 'UTC',
        '(GMT) Monrovia' => 'Africa/Monrovia',
        '(GMT+01:00) Amsterdam' => 'Europe/Amsterdam',
        '(GMT+01:00) Belgrade' => 'Europe/Belgrade',
        '(GMT+01:00) Berlin' => 'Europe/Berlin',
        '(GMT+01:00) Bern' => 'Europe/Berlin',
        '(GMT+01:00) Bratislava' => 'Europe/Bratislava',
        '(GMT+01:00) Brussels' => 'Europe/Brussels',
        '(GMT+01:00) Budapest' => 'Europe/Budapest',
        '(GMT+01:00) Copenhagen' => 'Europe/Copenhagen',
        '(GMT+01:00) Ljubljana' => 'Europe/Ljubljana',
        '(GMT+01:00) Madrid' => 'Europe/Madrid',
        '(GMT+01:00) Paris' => 'Europe/Paris',
        '(GMT+01:00) Prague' => 'Europe/Prague',
        '(GMT+01:00) Rome' => 'Europe/Rome',
        '(GMT+01:00) Sarajevo' => 'Europe/Sarajevo',
        '(GMT+01:00) Skopje' => 'Europe/Skopje',
        '(GMT+01:00) Stockholm' => 'Europe/Stockholm',
        '(GMT+01:00) Vienna' => 'Europe/Vienna',
        '(GMT+01:00) Warsaw' => 'Europe/Warsaw',
        '(GMT+01:00) West Central Africa' => 'Africa/Lagos',
        '(GMT+01:00) Zagreb' => 'Europe/Zagreb',
        '(GMT+02:00) Athens' => 'Europe/Athens',
        '(GMT+02:00) Bucharest' => 'Europe/Bucharest',
        '(GMT+02:00) Cairo' => 'Africa/Cairo',
        '(GMT+02:00) Harare' => 'Africa/Harare',
        '(GMT+02:00) Helsinki' => 'Europe/Helsinki',
        '(GMT+02:00) Istanbul' => 'Europe/Istanbul',
        '(GMT+02:00) Jerusalem' => 'Asia/Jerusalem',
        '(GMT+02:00) Kyev' => 'Europe/Kiev',
        '(GMT+02:00) Minsk' => 'Europe/Minsk',
        '(GMT+02:00) Pretoria' => 'Africa/Johannesburg',
        '(GMT+02:00) Riga' => 'Europe/Riga',
        '(GMT+02:00) Sofia' => 'Europe/Sofia',
        '(GMT+02:00) Tallinn' => 'Europe/Tallinn',
        '(GMT+02:00) Vilnius' => 'Europe/Vilnius',
        '(GMT+03:00) Baghdad' => 'Asia/Baghdad',
        '(GMT+03:00) Kuwait' => 'Asia/Kuwait',
        '(GMT+03:00) Moscow' => 'Europe/Moscow',
        '(GMT+03:00) Nairobi' => 'Africa/Nairobi',
        '(GMT+03:00) Riyadh' => 'Asia/Riyadh',
        '(GMT+03:00) St. Petersburg' => 'Europe/Moscow',
        '(GMT+03:00) Volgograd' => 'Europe/Volgograd',
        '(GMT+03:30) Tehran' => 'Asia/Tehran',
        '(GMT+04:00) Abu Dhabi' => 'Asia/Muscat',
        '(GMT+04:00) Baku' => 'Asia/Baku',
        '(GMT+04:00) Muscat' => 'Asia/Muscat',
        '(GMT+04:00) Tbilisi' => 'Asia/Tbilisi',
        '(GMT+04:00) Yerevan' => 'Asia/Yerevan',
        '(GMT+04:30) Kabul' => 'Asia/Kabul',
        '(GMT+05:00) Ekaterinburg' => 'Asia/Yekaterinburg',
        '(GMT+05:00) Islamabad' => 'Asia/Karachi',
        '(GMT+05:00) Karachi' => 'Asia/Karachi',
        '(GMT+05:00) Tashkent' => 'Asia/Tashkent',
        '(GMT+05:30) Chennai' => 'Asia/Kolkata',
        '(GMT+05:30) Kolkata' => 'Asia/Kolkata',
        '(GMT+05:30) Mumbai' => 'Asia/Kolkata',
        '(GMT+05:30) New Delhi' => 'Asia/Kolkata',
        '(GMT+05:45) Kathmandu' => 'Asia/Kathmandu',
        '(GMT+06:00) Almaty' => 'Asia/Almaty',
        '(GMT+06:00) Astana' => 'Asia/Dhaka',
        '(GMT+06:00) Dhaka' => 'Asia/Dhaka',
        '(GMT+06:00) Novosibirsk' => 'Asia/Novosibirsk',
        '(GMT+06:00) Sri Jayawardenepura' => 'Asia/Colombo',
        '(GMT+06:30) Rangoon' => 'Asia/Rangoon',
        '(GMT+07:00) Bangkok' => 'Asia/Bangkok',
        '(GMT+07:00) Hanoi' => 'Asia/Bangkok',
        '(GMT+07:00) Jakarta' => 'Asia/Jakarta',
        '(GMT+07:00) Krasnoyarsk' => 'Asia/Krasnoyarsk',
        '(GMT+08:00) Beijing' => 'Asia/Hong_Kong',
        '(GMT+08:00) Chongqing' => 'Asia/Chongqing',
        '(GMT+08:00) Hong Kong' => 'Asia/Hong_Kong',
        '(GMT+08:00) Irkutsk' => 'Asia/Irkutsk',
        '(GMT+08:00) Kuala Lumpur' => 'Asia/Kuala_Lumpur',
        '(GMT+08:00) Perth' => 'Australia/Perth',
        '(GMT+08:00) Singapore' => 'Asia/Singapore',
        '(GMT+08:00) Taipei' => 'Asia/Taipei',
        '(GMT+08:00) Ulaan Bataar' => 'Asia/Irkutsk',
        '(GMT+08:00) Urumqi' => 'Asia/Urumqi',
        '(GMT+09:00) Osaka' => 'Asia/Tokyo',
        '(GMT+09:00) Sapporo' => 'Asia/Tokyo',
        '(GMT+09:00) Seoul' => 'Asia/Seoul',
        '(GMT+09:00) Tokyo' => 'Asia/Tokyo',
        '(GMT+09:00) Yakutsk' => 'Asia/Yakutsk',
        '(GMT+09:30) Adelaide' => 'Australia/Adelaide',
        '(GMT+09:30) Darwin' => 'Australia/Darwin',
        '(GMT+10:00) Brisbane' => 'Australia/Brisbane',
        '(GMT+10:00) Canberra' => 'Australia/Sydney',
        '(GMT+10:00) Guam' => 'Pacific/Guam',
        '(GMT+10:00) Hobart' => 'Australia/Hobart',
        '(GMT+10:00) Melbourne' => 'Australia/Melbourne',
        '(GMT+10:00) Port Moresby' => 'Pacific/Port_Moresby',
        '(GMT+10:00) Sydney' => 'Australia/Sydney',
        '(GMT+10:00) Vladivostok' => 'Asia/Vladivostok',
        '(GMT+11:00) Magadan' => 'Asia/Magadan',
        '(GMT+11:00) New Caledonia' => 'Asia/Magadan',
        '(GMT+11:00) Solomon Is.' => 'Asia/Magadan',
        '(GMT+12:00) Auckland' => 'Pacific/Auckland',
        '(GMT+12:00) Fiji' => 'Pacific/Fiji',
        '(GMT+12:00) Kamchatka' => 'Asia/Kamchatka',
        '(GMT+12:00) Marshall Is.' => 'Pacific/Fiji',
        '(GMT+12:00) Wellington' => 'Pacific/Auckland',
        '(GMT+13:00) Nuku\'alofa' => 'Pacific/Tongatapu',
    ];
}

if (! function_exists('image_upload_form')) {

    /**
     * @param  string  $input_name
     * @param  string  $current_image_id
     * @param  array  $preferable_size
     */
    function image_upload_form($input_name = 'image_id', $current_image_id = '', $preferable_size = [])
    {
        if (! $input_name) {
            $input_name = 'image_id';
        }
        ?>
        <div class="image-wrap">
            <a href="javascript:;" data-toggle="filemanager">
                <?php
                $img_src = '';
        if ($current_image_id) {
            $img_src = media_image_uri($current_image_id)->thumbnail;
        } else {
            $img_src = asset('uploads/placeholder-image.png');
        }
        ?>
                <img src="<?php echo $img_src; ?>" alt="" class="img-thumbnail"/>
            </a>
            <input type="hidden" name="<?php echo $input_name; ?>" class="image-input"
                   value="<?php echo $current_image_id; ?>">

            <?php
            if (count($preferable_size)) {
                $width = array_get($preferable_size, 0);
                $height = array_get($preferable_size, 1);
                $text = __t('preferable_size').": w-{$width}px X h-{$height}px";
                echo "<p class='img_preferable_size_info my-2 text-info'> {$text} </p>";
            }
        ?>

        </div>
        <?php
    }
}
function get_option($key = '', $default = null)
{
    $options = config('options');
    if (! $key) {
        return $options;
    }

    $value = get_from_array($key, $options);
    if ($value) {
        return $value;
    }

    return apply_filters('options', $default);
}

function get_from_array($key = null, $arr = [])
{
    if (strpos($key, '.') === false) {
        $value = array_get($arr, $key);
        if ($value) {
            if (is_string($value) && substr($value, 0, 18) === 'json_encode_value_') {
                $value = json_decode(substr($value, 18), true);
            }

            return $value;
        }
    } else {

        $firstKey = substr($key, 0, strpos($key, '.'));
        $secondKey = substr($key, strpos($key, '.') + 1);

        $value = array_get($arr, $firstKey);
        if ($value) {
            if (is_string($value) && substr($value, 0, 18) === 'json_encode_value_') {
                $value = json_decode(substr($value, 18), true);
            }

            return array_get($value, $secondKey);
        }
    }

    return null;
}

if (! function_exists('media_image_uri')) {
    function media_image_uri($media = null)
    {
        $sizes = config('media.size');
        $sizes['original'] = 'Original Image';
        $sizes['full'] = 'Original Image';

        foreach ($sizes as $img_size => $name) {
            $sizes[$img_size] = asset('uploads/placeholder-image.png');
        }

        if ($media) {
            if (! is_object($media) || ! $media instanceof \App\Models\Media) {
                $media = \App\Models\Media::find($media);
            }

            if ($media) {
                $source = get_option('default_storage');

                $url_path = null;
                $full_url_path = null;

                //Getting resized images
                foreach ($sizes as $img_size => $name) {
                    if ($img_size === 'original' || $img_size === 'full') {
                        $thumb_size = '';
                    } else {
                        $thumb_size = $img_size.'/';
                    }

                    if ($source == 'public') {
                        $url_path = asset("uploads/images/{$thumb_size}".$media->slug_ext);
                    } elseif ($source == 's3') {
                        try {
                            $url_path = \Illuminate\Support\Facades\Storage::disk('s3')->url("uploads/images/{$thumb_size}".$media->slug_ext);
                        } catch (\Exception $exception) {
                            //
                        }
                    }
                    $sizes[$img_size] = $url_path;
                }

            }
        }

        return (object) $sizes;
    }
}
function next_curriculum_item_id($course_id)
{
    $order_number = (int) DB::table('contents')->where('course_id', $course_id)->max('sort_order');

    return $order_number + 1;
}

function unique_slug($title = '', $model = 'Course', $skip_id = 0)
{
    $slug = str_slug($title);

    if (empty($slug)) {
        $string = mb_strtolower($title, 'UTF-8');
        $string = preg_replace("/[\/\.]/", ' ', $string);
        $string = preg_replace("/[\s-]+/", ' ', $string);
        $slug = preg_replace("/[\s_]/", '-', $string);
    }

    //get unique slug...
    $nSlug = $slug;
    $i = 0;

    $model = str_replace(' ', '', "\App\Models\ ".$model);

    if ($skip_id === 0) {
        while (($model::whereSlug($nSlug)->count()) > 0) {
            $i++;
            $nSlug = $slug.'-'.$i;
        }
    } else {
        while (($model::whereSlug($nSlug)->where('id', '!=', $skip_id)->count()) > 0) {
            $i++;
            $nSlug = $slug.'-'.$i;
        }
    }
    if ($i > 0) {
        $newSlug = substr($nSlug, 0, strlen($slug)).'-'.$i;
    } else {
        $newSlug = $slug;
    }

    return $newSlug;
}

if (! function_exists('str_slug')) {
    /**
     * Generate a URL friendly "slug" from a given string.
     *
     * @param  string  $title
     * @param  string  $separator
     * @param  string  $language
     * @return string
     */
    function str_slug($title, $separator = '-', $language = 'en')
    {
        return Str::slug($title, $separator, $language);
    }

    if (! function_exists('array_except')) {
        /**
         * Get all of the given array except for a specified array of keys.
         *
         * @param  array  $array
         * @param  array|string  $keys
         * @return array
         */
        function array_except($array, $keys)
        {
            return Arr::except($array, $keys);
        }
    }
}

if (! function_exists('question_types')) {
    function question_types($type = null)
    {
        $types = [
            'radio' => __t('single_choice'),
            'checkbox' => __t('multiple_choice'),
            'text' => __t('single_line_text'),
            'textarea' => __t('multi_line_text'),
        ];

        if ($type) {
            return array_get($types, $type);
        }

        return apply_filters('questions_types', $types);
    }
}

if (! function_exists('checked')) {
    function checked($checked, $current = true, $echo = true)
    {
        return __checked_selected_helper($checked, $current, $echo, 'checked');
    }
}
if (! function_exists('__t')) {
    function __t($key = null)
    {
        $language = config('lang_str');
        $text = array_get($language, $key);

        if ($text) {
            return $text;
        }

        return $key;
    }
}

if (! function_exists('date_time_format')) {
    function date_time_format()
    {
        return get_option('date_format').' '.get_option('time_format');
    }
}
function seconds_to_time_format($seconds = 0)
{
    if (! $seconds) {
        return '00:00';
    }

    $hours = floor($seconds / 3600);
    $mins = floor(($seconds - $hours * 3600) / 60);
    $s = $seconds - ($hours * 3600 + $mins * 60);

    $mins = ($mins < 10 ? '0'.$mins : ''.$mins);
    $s = ($s < 10 ? '0'.$s : ''.$s);

    //    $time = ($hours>0?$hours.":":"").$mins.":".$s;
    $time = ($hours > 9 ? $hours : '0'.$hours).':'.$mins.':'.$s;

    return $time;
}

function timeToSeconds(string $time): int
{
    $arr = explode(':', $time);
    if (count($arr) === 3) {
        return $arr[0] * 3600 + $arr[1] * 60 + $arr[2];
    }

    return $arr[0] * 60 + $arr[1];
}

function time_to_human($times)
{
    $timesArr = explode(':', $times);
    $timeChange = '';
    if ($timesArr[0] != 00) {
        $minute = '';
        if ($timesArr[0] <= 1) {
            if ($timesArr[1] != 00) {
                if (($timesArr[1] > 01)) {
                    $minute = $timesArr[1].' m';
                } else {
                    $minute = $timesArr[1].'m';
                }

            }
            $timeChange = $timesArr[0].' h '.$minute;
        } else {
            $minute = '';
            if ($timesArr[1] != 00) {
                if (($timesArr[1] > 01)) {
                    $minute = $timesArr[1].' m';
                } else {
                    $minute = $timesArr[1].' m';
                }

            }
            $timeChange = $timesArr[0].' h '.$minute;
        }

    } else {
        $minute = '';
        if ($timesArr[1] != 00) {
            if (($timesArr[1] > 9)) {
                $minute = $timesArr[1].' m';
            } else {
                $minute = (int) $timesArr[1].' m';
            }

        }
        $timeChange = $minute;
    }

    return $timeChange;
}

function ConvertSectoDay($n)
{

    $n = ($n % (24 * 3600));
    $hour = $n / 3600;

    $n %= 3600;
    $minutes = $n / 60;

    $n %= 60;
    $seconds = $n;

    return " $hour hours $minutes minutes $seconds seconds";

}

if (! function_exists('HandleResponse')) {
    function HandleResponse($obj)
    {
        if (! $obj || $obj == []) {
            abort(response()->json(['status' => false, 'message' => 'No Data Was Found', 'data' => []], 404));
        } else {
            return $obj;
        }
    }
}

if (! function_exists('array_pluck')) {
    /**
     * Pluck an array of values from an array.
     *
     * @param  array  $array
     * @param  string|array  $value
     * @param  string|array|null  $key
     * @return array
     */
    function array_pluck($array, $value, $key = null)
    {
        return Arr::pluck($array, $value, $key);
    }
}
