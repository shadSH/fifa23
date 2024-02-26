<?php

namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateCrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'technobase:all
                            {name : The name of the Crud.}
                            {--fields= : Fields name for the form & migration.}
                            {--crud-model= : Fields name for the form & migration.}
                            {--validations= : Validation details for the fields.}
                            {--controller-namespace= : Namespace of the controller.}
                            {--model-namespace= : Namespace of the model inside "app" dir.}
                            {--pk=id : The name of the primary key.}
                            {--pagination=25 : The amount of models per page for index pages.}
                            {--indexes= : The fields to add an index to.}
                            {--foreign-keys= : The foreign keys for the table.}
                            {--relationships= : The relationships for the model.}
                            {--route=yes : Include Crud route to routes.php? yes|no.}
                            {--route-group= : Prefix of the route group.}
                            {--view-path= : The name of the view path.}
                            {--localize=no : Allow to localize? yes|no.}
                            {--locales=en : Locales language type.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Crud including controller, model, views & migrations.';

    /** @var string */
    protected $routeName = '';

    /** @var string */
    protected $controller = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $defaultIndex = 0;
        //        $type = $this->choice('Which type do you want to generate ?', ['Standard', 'API'], $defaultIndex);
        $type = 'DEFAULT';
        $name = $this->argument('name');
        $crud_model = $this->option('crud-model');

        $modelName = Str::singular($name);
        $migrationName = str_plural(snake_case($name));
        $tableName = $migrationName;
        $routeGroup = $this->option('route-group');
        $this->routeName = ($routeGroup) ? $routeGroup.'/'.snake_case($name, '_') : snake_case($name, '_');
        $perPage = intval($this->option('pagination'));
        $controllerNamespace = ($this->option('controller-namespace')) ? $this->option('controller-namespace').'\\' : '';
        $modelNamespace = ($this->option('model-namespace')) ? trim($this->option('model-namespace')).'\\' : '';
        $fields = rtrim($this->option('fields'), ';');

        $primaryKey = $this->option('pk');
        $viewPath = $this->option('view-path');
        $foreignKeys = $this->option('foreign-keys');
        $fieldsArray = explode(';', $fields);
        $fillableArray = [];
        foreach ($fieldsArray as $item) {
            $spareParts = explode('#', trim($item));
            $fillableArray[] = $spareParts[0];
        }
        $commaSeparetedString = implode("', '", $fillableArray);
        $fillable = "['".$commaSeparetedString."']";
        $localize = $this->option('localize');
        $locales = $this->option('locales');
        $indexes = $this->option('indexes');
        $relationships = $this->option('relationships');

        $validations = trim($this->option('validations'));

        if ($type == 'API') {
            $this->call('technobase:api-controller', [
                'name' => $controllerNamespace.$name.'Controller',
                '--crud-name' => $name,
                '--model-name' => $modelName,
                '--model-namespace' => $modelNamespace,
                '--route-group' => $routeGroup,
                '--pagination' => $perPage,
                '--fields' => $fields,
                '--validations' => $validations,
            ]);
        } else {
            $this->call('technobase:controller', [
                'name' => $controllerNamespace.$name.'Controller',
                '--crud-name' => $name,
                '--model-name' => $modelName,
                '--crud-model' => $crud_model,
                '--model-namespace' => $modelNamespace,
                '--view-path' => $viewPath,
                '--route-group' => $routeGroup,
                '--pagination' => $perPage,
                '--fields' => $fields,
                '--validations' => $validations,
            ]);
            $this->call('technobase:view', ['name' => $name, '--fields' => $fields, '--validations' => $validations, '--view-path' => $viewPath, '--route-group' => $routeGroup, '--localize' => $localize, '--pk' => $primaryKey]);

        }
        $this->call('technobase:model', ['name' => $modelNamespace.$modelName, '--fillable' => $fillable, '--table' => $tableName, '--pk' => $primaryKey, '--relationships' => $relationships]);
        $this->call('technobase:migration', ['name' => $migrationName, '--schema' => $fields, '--pk' => $primaryKey, '--indexes' => $indexes, '--foreign-keys' => $foreignKeys]);
        if ($localize == 'yes') {
            $this->call('technobase:lang', ['name' => $name, '--fields' => $fields, '--locales' => $locales]);
        }
        // For optimizing the class loader
        //$this->callSilent('optimize');

        // Updating the Http/routes.php file
        if ($type == 'API') {
            $routeFile = base_path('routes/api.php');
        } else {
            $routeFile = base_path('routes/web.php');
        }
        if (file_exists($routeFile) && (strtolower($this->option('route')) === 'yes')) {
            $this->controller = ($controllerNamespace != '') ? $controllerNamespace.'\\'.$name.'Controller' : $name.'Controller';
            $isAdded = File::append($routeFile, "\n".implode("\n", $this->addRoutes()));
            if ($isAdded) {

                $contents = File::get($routeFile);
                $lines = explode("\n", $contents);
                $index = array_search('<?php', $lines);
                array_splice($lines, $index + 1, 0, $this->addControllerUse());
                $newContents = implode("\n", $lines);
                File::put($routeFile, $newContents);

                $this->info('TechnoBase Crud working... Route added to '.$routeFile);
            } else {
                $this->info('Ups.. Your TechnoBase Crud is wrong, Unable to add the route to '.$routeFile);
            }
        }
    }

    /**
     * Add routes.
     *
     * @return  array
     */
    protected function addRoutes()
    {
        $snake_name_route = $this->routeName;
        $snake_status_change = '{'.$snake_name_route.'}';
        $array = [
            "Route::get('/$snake_name_route/status_change/$snake_status_change', [$this->controller::class, 'status_change'])->name('$snake_name_route.status_change');",
            "Route::get('/$snake_name_route/data', [$this->controller::class, 'data'])->name('$snake_name_route.data');",
            "Route::resource('".$snake_name_route."', $this->controller::class);",
        ];

        return $array;
    }

    protected function addControllerUse()
    {
        $controller_name = $this->controller;
        $array = [
            'use App\Http\Controllers\\'.$controller_name.';',
        ];

        return $array;
    }
}
