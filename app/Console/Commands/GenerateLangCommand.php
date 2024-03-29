<?php

namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;

class GenerateLangCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'technobase:lang
                            {name : The name of the Crud.}
                            {--fields= : The fields name for the form.}
                            {--locales=en : The locale for the file.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create lang file for the Crud.';

    /**
     * Name of the Crud.
     *
     * @var string
     */
    protected $crudName = '';

    /**
     * The locale string.
     *
     * @var string
     */
    protected $locales;

    /**
     * Form's fields.
     *
     * @var array
     */
    protected $formFields = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->viewDirectoryPath = config('technobase_generator.custom_template')
        ? config('technobase_generator.path')
        : __DIR__.'/../stubs/';
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->crudName = $this->argument('name');
        $this->locales = explode(',', $this->option('locales'));

        $fields = $this->option('fields');
        $fieldsArray = explode(';', $fields);

        $this->formFields = [];

        if ($fields) {
            $x = 0;
            foreach ($fieldsArray as $item) {
                $itemArray = explode('#', $item);
                $this->formFields[$x]['name'] = trim($itemArray[0]);
                $this->formFields[$x]['type'] = trim($itemArray[1]);
                $this->formFields[$x]['required'] = (isset($itemArray[2]) && (trim($itemArray[2]) == 'req' || trim($itemArray[2]) == 'required')) ? true : false;

                $x++;
            }
        }

        foreach ($this->locales as $locale) {
            $locale = trim($locale);
            $path = config('view.paths')[0].'/../lang/'.$locale.'/';

            //create directory for locale
            if (! File::isDirectory($path)) {
                File::makeDirectory($path, 0755, true);
            }

            $langFile = $this->viewDirectoryPath.'lang.stub';
            $newLangFile = $path.lcfirst($this->crudName).'.php';
            if (! File::copy($langFile, $newLangFile)) {
                echo "failed to copy $langFile...\n";
            } else {
                $this->templateVars($newLangFile);
            }

            $this->info('Lang ['.$locale.'] created successfully.');
        }
    }

    /**
     * Translate form's fields.
     *
     * @param  string  $newLangFile
     * @return void
     */
    private function templateVars($newLangFile)
    {
        $messages = [];
        foreach ($this->formFields as $field) {
            $index = $field['name'];
            $text = ucwords(strtolower(str_replace('_', ' ', $index)));
            $messages[] = "'$index' => '$text'";
        }

        File::put($newLangFile, str_replace('%%messages%%', implode(",\n", $messages), File::get($newLangFile)));
    }
}
