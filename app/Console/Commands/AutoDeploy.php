<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class AutoDeploy extends Command
{
    protected $signature = 'autodeploy {--refresh : Refresh the existing AutoDeploy directory}';

    protected $description = 'Pull the AutoDeploy directory from GitHub or refresh an existing directory';

    public function handle()
    {
        $refresh = $this->option('refresh');
        $autodeployPath = base_path('autodeploy/PythonScripts');

        if ($refresh) {
            $this->refreshAutoDeploy($autodeployPath);
        } else {
            $this->pullAutoDeploy($autodeployPath);
        }
    }

    protected function pullAutoDeploy($autodeployPath)
    {
        $this->info('Pulling the AutoDeploy directory from GitHub...');
        exec('git clone https://github.com/your-username/your-repo.git ' . $autodeployPath);
        $this->info('AutoDeploy directory pulled successfully.');
    }

    protected function refreshAutoDeploy($autodeployPath)
    {
        if (File::exists($autodeployPath)) {
            $this->info('Refreshing the AutoDeploy directory...');
            exec('cd ' . $autodeployPath . ' && git pull origin main');
            $this->info('AutoDeploy directory refreshed successfully.');
        } else {
            $this->error('The AutoDeploy directory does not exist. Use "pull:autodeploy" to initially pull the directory.');
        }
    }
}
