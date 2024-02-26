<?php

namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateViewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'technobase:view
                            {name : The name of the Crud.}
                            {--custom-data= : Some additonnal values to use in the crud.}
                            {--fields= : The fields name for the form.}
                            {--view-path= : The name of the view path.}
                            {--route-group= : Prefix of the route group.}
                            {--pk=id : The name of the primary key.}
                            {--validations= : Validation details for the fields.}
                            {--localize=no : Localize the view? yes|no.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create views for the Crud.';

    /**
     * View Directory Path.
     *
     * @var string
     */
    protected $viewDirectoryPath;

    /**
     *  Form field types collection.
     *
     * @var array
     */
    protected $typeLookup = [
        'string' => 'text',
        'char' => 'text',
        'varchar' => 'text',
        'text' => 'textarea',
        'mediumtext' => 'textarea',
        'longtext' => 'textarea',
        'json' => 'textarea',
        'jsonb' => 'textarea',
        'binary' => 'textarea',
        'password' => 'password',
        'email' => 'email',
        'number' => 'number',
        'integer' => 'number',
        'bigint' => 'number',
        'mediumint' => 'number',
        'tinyint' => 'number',
        'smallint' => 'number',
        'decimal' => 'number',
        'double' => 'number',
        'float' => 'number',
        'date' => 'date',
        'datetime' => 'datetime-local',
        'timestamp' => 'datetime-local',
        'time' => 'time',
        'boolean' => 'radio',
        'enum' => 'select',
        'select' => 'select',
        'file' => 'file',
        'image' => 'image',
        'ckeditor' => 'ckeditor',
    ];

    /**
     * Variables that can be used in stubs
     *
     * @var array
     */
    protected $vars = [
        'formFields',
        'formFieldsHtml',
        'varName',
        'crudName',
        'crudNameCap',
        'crudNameSingular',
        'primaryKey',
        'modelName',
        'modelNameCap',
        'viewName',
        'routePrefix',
        'routePrefixCap',
        'routeGroup',
        'formHeadingHtml',
        'formBodyHtml',
        'viewTemplateDir',
        'formBodyHtmlForShowView',
        'createTemplate',
        'tableView',
        'scriptView',
        'updateTemplate',
        'valueUpdate',
        'formFieldsHtmlUpdate',
        'ckeditorView',
        'ckeditorUpdateView',
    ];

    /**
     * Form's fields.
     *
     * @var array
     */
    protected $formFields = [];

    /**
     * Html of Form's fields.
     *
     * @var string
     */
    protected $formFieldsHtml = '';

    /**
     * Number of columns to show from the table. Others are hidden.
     *
     * @var int
     */
    protected $defaultColumnsToShow = 3;

    /**
     * Variable name with first letter in lowercase
     *
     * @var string
     */
    protected $varName = '';

    /**
     * Name of the Crud.
     *
     * @var string
     */
    protected $crudName = '';

    /**
     * Crud Name in capital form.
     *
     * @var string
     */
    protected $crudNameCap = '';

    /**
     * Crud Name in singular form.
     *
     * @var string
     */
    protected $crudNameSingular = '';

    /**
     * Primary key of the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Name of the Model.
     *
     * @var string
     */
    protected $modelName = '';

    /**
     * Name of the Model with first letter in capital
     *
     * @var string
     */
    protected $modelNameCap = '';

    /**
     * Name of the View Dir.
     *
     * @var string
     */
    protected $viewName = '';

    /**
     * Prefix of the route
     *
     * @var string
     */
    protected $routePrefix = '';

    /**
     * Prefix of the route with first letter in capital letter
     *
     * @var string
     */
    protected $routePrefixCap = '';

    /**
     * Name or prefix of the Route Group.
     *
     * @var string
     */
    protected $routeGroup = '';

    /**
     * Html of the form heading.
     *
     * @var string
     */
    protected $formHeadingHtml = '';

    /**
     * Html of the form body.
     *
     * @var string
     */
    protected $formBodyHtml = '';

    /**
     * Html of view to show.
     *
     * @var string
     */
    protected $formBodyHtmlForShowView = '';

    /**
     * User defined values
     *
     * @var array
     */
    protected $customData = [];

    /**
     * Template directory where views are generated
     *
     * @var string
     */
    protected $viewTemplateDir = '';

    /**
     * Delimiter used for replacing values
     *
     * @var array
     */
    protected $delimiter;

    protected $createTemplate = '';

    protected $tableView = '';

    protected $scriptView = '';

    protected $updateTemplate = '';

    protected $valueUpdate = '';

    protected $formFieldsHtmlUpdate = '';

    protected $ckeditorView = '';

    protected $ckeditorUpdateView = '';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->viewDirectoryPath = config('technobase_generator.custom_template')
            ? config('technobase_generator.path')
            : __DIR__.'/../stubs/';

        if (config('technobase_generator.view_columns_number')) {
            $this->defaultColumnsToShow = config('technobase_generator.view_columns_number');
        }

        $this->delimiter = config('technobase_generator.custom_delimiter') ? config('technobase_generator.custom_delimiter') : ['%%', '%%'];
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->crudName = strtolower($this->argument('name'));
        $this->varName = lcfirst($this->argument('name'));
        $this->crudNameCap = strtolower($this->crudName);
        $this->crudNameSingular = Str::singular($this->crudName);
        $this->modelName = Str::singular($this->argument('name'));
        $this->modelNameCap = ucfirst($this->modelName);
        $this->customData = $this->option('custom-data');
        $this->primaryKey = $this->option('pk');
        $this->routeGroup = ($this->option('route-group')) ? $this->option('route-group').'/' : $this->option('route-group');
        $this->routePrefix = ($this->option('route-group')) ? $this->option('route-group') : '';
        $this->routePrefixCap = ucfirst($this->routePrefix);
        $this->viewName = snake_case($this->argument('name'), '_');

        $viewDirectory = config('view.paths')[0].'/';
        if ($this->option('view-path')) {
            $this->userViewPath = $this->option('view-path');
            $path = $viewDirectory.$this->userViewPath.'/'.$this->viewName.'/';
        } else {
            $path = $viewDirectory.$this->viewName.'/';

        }
        $this->viewTemplateDir = isset($this->userViewPath) ? $this->userViewPath.'.'.$this->viewName : $this->viewName;

        if (! File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $fields = $this->option('fields');
        $fieldsArray = explode(';', $fields);
        $validations = $this->option('validations');
        $show_array = explode(';', $validations);

        $html = '';
        $table_view = '';
        $html .= '<th> ID </th>'.PHP_EOL;
        $table_view .= '
                    {
                        data: "id",
                        name: "id"
                    },
                    ';

        foreach ($show_array as $table) {

            $explode = explode('#', $table);
            $title = $explode[0];
            if (in_array('show', $explode)) {
                $is_show = 1;
            } else {
                $is_show = 0;
            }

            if ($is_show == 1) {
                $html .= '<th> '.$title.' </th>'.PHP_EOL;

                $table_view .= '
                    {
                        data: "'.$title.'",
                        name: "'.$title.'"
                    },
                    ';
            }

        }

        $html .= '<th> Active </th>'.PHP_EOL;
        $html .= '<th> Action </th>'.PHP_EOL;

        $table_view .= '
                    {
                        data: "checkbox",
                        name: "checkbox"
                    },
                    ';

        $table_view .= '
                    {
                        data: "action",
                        name: "action"
                    },
                    ';

        $this->tableView = $html;
        $this->scriptView = $table_view;

        $this->formFields = [];

        if ($fields) {
            $x = 0;
            foreach ($fieldsArray as $item) {
                $itemArray = explode('#', $item);

                $this->formFields[$x]['name'] = trim($itemArray[0]);
                $this->formFields[$x]['type'] = trim($itemArray[1]);
                $this->formFields[$x]['required'] = preg_match('/'.$itemArray[0].'/', $validations) ? true : false;

                if ($this->formFields[$x]['type'] == 'select' && isset($itemArray[2])) {
                    $options = trim($itemArray[2]);
                    $options = str_replace('options=', '', $options);
                    $optionsArray = explode(',', $options);

                    $commaSeparetedString = implode("', '", $optionsArray);
                    $options = "['".$commaSeparetedString."']";

                    $this->formFields[$x]['options'] = $options;
                }

                $x++;
            }
        }

        $ckeditor = '';
        foreach ($this->formFields as $item) {
            $this->formFieldsHtml .= $this->createField($item);

            if ($item['type'] == 'ckeditor') {
                $title = $item['name'];
                $ckeditor .= "ClassicEditor
            .create(document.querySelector('.$title'),{
                ckfinder: {
                    uploadUrl: '{{route('image.upload').'?_token='.csrf_token()}}',
                }
            })
            .catch(error => {
                console.error(error);
            });".PHP_EOL;
            }

        }

        $this->ckeditorView = $ckeditor;

        $this->createTemplate = $this->formFieldsHtml;

        $ckeditor_update = '';
        foreach ($this->formFields as $item) {

            $this->formFieldsHtmlUpdate .= $this->createField($item, 1);

            if ($item['type'] == 'ckeditor') {
                $title = $item['name'].'_edit';
                $ckeditor_update .= "ClassicEditor
            .create(document.querySelector('.$title'),{
                ckfinder: {
                    uploadUrl: '{{route('image.upload').'?_token='.csrf_token()}}',
                }
            })
            .catch(error => {
                console.error(error);
            });".PHP_EOL;
            }
        }

        $this->updateTemplate = $this->formFieldsHtmlUpdate;
        $this->ckeditorUpdateView = $ckeditor_update;

        $i = 0;
        foreach ($this->formFields as $key => $value) {
            if ($i == $this->defaultColumnsToShow) {
                break;
            }

            $field = $value['name'];
            $label = ucwords(str_replace('_', ' ', $field));
            if ($this->option('localize') == 'yes') {
                $label = '{{ trans(\''.$this->crudName.'.'.$field.'\') }}';
            }
            $this->formHeadingHtml .= '<th>'.$label.'</th>';
            $this->formBodyHtml .= '<td>{{ $item->'.$field.' }}</td>';
            $this->formBodyHtmlForShowView .= '<tr><th> '.$label.' </th><td> {{ $%%crudNameSingular%%->'.$field.' }} </td></tr>';

            $i++;
        }

        $this->templateStubs($path);

        $this->info('View created successfully.');
    }

    /**
     * Default template configuration if not provided
     *
     * @return array
     */
    private function defaultTemplating()
    {
        return [
            'index' => [
                'formHeadingHtml',
                'formBodyHtml',
                'crudName',
                'crudNameCap',
                'modelName',
                'viewName',
                'routeGroup',
                'primaryKey',
                'tableView',
            ],
            'create' => [
                'crudName',
                'htmlDesign',
                'crudNameCap',
                'modelName',
                'modelNameCap',
                'viewName',
                'routeGroup',
                'createTemplate',
                'viewTemplateDir',
                'valueUpdate',
            ],
            'update' => [
                'crudName',
                'crudNameSingular',
                'crudNameCap',
                'modelNameCap',
                'modelName',
                'viewName',
                'routeGroup',
                'primaryKey',
                'updateTemplate',
                'viewTemplateDir',
                'updateTemplate',
                'valueUpdate',
                'ckeditorUpdateView',
            ],
            'script' => [
                'formHeadingHtml',
                'formBodyHtml',
                'formBodyHtmlForShowView',
                'crudName',
                'crudNameSingular',
                'crudNameCap',
                'modelName',
                'viewName',
                'routeGroup',
                'primaryKey',
                'scriptView',
                'ckeditorView',
            ],
        ];
    }

    /**
     * Generate files from stub
     */
    protected function templateStubs($path)
    {
        $dynamicViewTemplate = $this->defaultTemplating();

        foreach ($dynamicViewTemplate as $name => $vars) {

            $file = $this->viewDirectoryPath.$name.'.blade.stub';
            $newFile = $path.$name.'.blade.php';

            if (! File::copy($file, $newFile)) {
                echo "failed to copy $file...\n";
            } else {

                $this->templateVars($newFile, $vars);
                $this->userDefinedVars($newFile);
            }
        }
    }

    /**
     * Update specified values between delimiter with real values
     */
    protected function templateVars($file, $vars)
    {
        $start = $this->delimiter[0];
        $end = $this->delimiter[1];

        foreach ($vars as $var) {
            $replace = $start.$var.$end;
            if (in_array($var, $this->vars)) {
                File::put($file, str_replace($replace, $this->$var, File::get($file)));
            }
        }
    }

    /**
     * Update custom values between delimiter  with real values
     */
    protected function userDefinedVars($file)
    {
        $start = $this->delimiter[0];
        $end = $this->delimiter[1];

        if ($this->customData !== null) {
            $customVars = explode(';', $this->customData);
            foreach ($customVars as $rawVar) {
                $arrayVar = explode('=', $rawVar);
                File::put($file, str_replace($start.$arrayVar[0].$end, $arrayVar[1], File::get($file)));
            }
        }

    }

    /**
     * Form field wrapper.
     *
     * @param  string  $item
     * @param  string  $field
     * @return string
     */
    protected function wrapField($item, $field)
    {
        $formGroup = File::get($this->viewDirectoryPath.'form-fields/wrap-field.blade.stub');

        $labelText = "'".ucwords(strtolower(str_replace('_', ' ', $item['name'])))."'";

        if ($this->option('localize') == 'yes') {
            $labelText = 'trans(\''.$this->crudName.'.'.$item['name'].'\')';
        }

        return sprintf($formGroup, $item['name'], $labelText, $field);
    }

    /**
     * Form field generator.
     *
     * @param  array  $item
     * @return string
     */
    protected function createField($item, $type = 0)
    {
        switch ($this->typeLookup[$item['type']]) {
            case 'password':
                return $this->createPasswordField($item, $type);
            case 'datetime-local':
            case 'time':
                return $this->createInputField($item, $type);
            case 'radio':
                return $this->createRadioField($item, $type);
            case 'image':
                return $this->createImageField($item, $type);
            case 'textarea':
                return $this->createTextAreaField($item, $type);
            case 'ckeditor':
                return $this->createTextAreaField($item, $type);
            case 'select':
            case 'enum':
                return $this->createSelectField($item, $type);
            default: // text
                return $this->createFormField($item, $type);
        }
    }

    /**
     * Create a specific field using the form helper.
     *
     * @param  array  $item
     * @return string
     */
    protected function createFormField($item, $type = 0)
    {
        $required = ($item['required'] === true) ? ', required' : '';

        $markup = File::get($this->viewDirectoryPath.'form-fields/form-field.blade.stub');
        $markup = str_replace('%%required%%', $required, $markup);
        if ($type == 1) {

            $value = 'value="{{$'.$this->viewName.'->'.$item['name'].'}}"';
            $markup = str_replace('%%valueUpdate%%', $value, $markup);
        } else {
            $markup = str_replace('%%valueUpdate%%', '', $markup);
        }
        $markup = str_replace('%%fieldType%%', $this->typeLookup[$item['type']], $markup);
        $markup = str_replace('%%itemName%%', $item['name'], $markup);

        return $this->wrapField(
            $item,
            $markup
        );
    }

    /**
     * Create a password field using the form helper.
     *
     * @param  array  $item
     * @return string
     */
    protected function createPasswordField($item, $type = 0)
    {
        $required = ($item['required'] === true) ? ', required ' : '';

        $markup = File::get($this->viewDirectoryPath.'form-fields/password-field.blade.stub');
        if ($type == 1) {

            $value = 'value="{{$'.$this->viewName.'->'.$item['name'].'}}"';
            $markup = str_replace('%%valueUpdate%%', $value, $markup);
        } else {
            $markup = str_replace('%%valueUpdate%%', '', $markup);
        }

        $markup = str_replace('%%required%%', $required, $markup);
        $markup = str_replace('%%itemName%%', $item['name'], $markup);

        return $this->wrapField(
            $item,
            $markup
        );
    }

    /**
     * Create a generic input field using the form helper.
     *
     * @param  array  $item
     * @return string
     */
    protected function createInputField($item, $type = 0)
    {
        $required = ($item['required'] === true) ? ', required' : '';

        $markup = File::get($this->viewDirectoryPath.'form-fields/input-field.blade.stub');
        $markup = str_replace('%%required%%', $required, $markup);

        if ($type == 1) {

            $value = 'value="{{$'.$this->viewName.'->'.$item['name'].'}}"';
            $markup = str_replace('%%valueUpdate%%', $value, $markup);
        } else {
            $markup = str_replace('%%valueUpdate%%', '', $markup);
        }

        $markup = str_replace('%%fieldType%%', $this->typeLookup[$item['type']], $markup);
        $markup = str_replace('%%itemName%%', $item['name'], $markup);

        return $this->wrapField(
            $item,
            $markup
        );
    }

    protected function createImageField($item, $type = 0)
    {
        $required = ($item['required'] === true) ? ', required' : '';

        $markup = File::get($this->viewDirectoryPath.'form-fields/image.blade.stub');
        $markup = str_replace('%%required%%', $required, $markup);

        if ($type == 1) {

            $value = 'value="{{$'.$this->viewName.'->'.$item['name'].'}}"';
            $markup = str_replace('%%valueUpdate%%', $value, $markup);
        } else {
            $markup = str_replace('%%valueUpdate%%', '', $markup);
        }

        $markup = str_replace('%%fieldType%%', $this->typeLookup[$item['type']], $markup);
        $markup = str_replace('%%itemName%%', $item['name'], $markup);

        return $this->wrapField(
            $item,
            $markup
        );
    }

    protected function createTextAreaField($item, $type = 0)
    {
        $required = ($item['required'] === true) ? ', required' : '';

        $markup = File::get($this->viewDirectoryPath.'form-fields/text-area.blade.stub');
        $markup = str_replace('%%required%%', $required, $markup);

        if ($type == 1) {

            $value = '{{$'.$this->viewName.'->'.$item['name'].'}}';
            $markup = str_replace('%%valueUpdate%%', $value, $markup);
            $markup = str_replace('%%className%%', $item['name'].'_edit', $markup);
        } else {
            $markup = str_replace('%%valueUpdate%%', '', $markup);
            $markup = str_replace('%%className%%', $item['name'], $markup);
        }
        $markup = str_replace('%%itemName%%', $item['name'], $markup);
        $markup = str_replace('%%fieldType%%', $this->typeLookup[$item['type']], $markup);

        return $this->wrapField(
            $item,
            $markup
        );
    }

    /**
     * Create a yes/no radio button group using the form helper.
     *
     * @param  array  $item
     * @return string
     */
    protected function createRadioField($item, $type = 0)
    {
        $markup = File::get($this->viewDirectoryPath.'form-fields/radio-field.blade.stub');

        return $this->wrapField($item, sprintf($markup, $item['name']));
    }

    /**
     * Create a select field using the form helper.
     *
     * @param  array  $item
     * @return string
     */
    protected function createSelectField($item, $type = 0)
    {
        $required = ($item['required'] === true) ? ', required' : '';

        $markup = File::get($this->viewDirectoryPath.'form-fields/select-field.blade.stub');
        $markup = str_replace('%%required%%', $required, $markup);
        $markup = str_replace('%%options%%', $item['options'], $markup);
        $markup = str_replace('%%itemName%%', $item['name'], $markup);

        return $this->wrapField(
            $item,
            $markup
        );
    }
}
