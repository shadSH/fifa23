<?php

namespace App\AutoDeploy;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Process;

class AutoDeployController extends Controller
{
    public function executePythonScript()
    {
        $output = [];
        $returnValue = 0;
        $pythonScriptPath = base_path('AutoDeploy/autodeploy.py');

        Process::fromShellCommandline('python '.$pythonScriptPath)
            ->run(function ($type, $line) use (&$output) {
                $output[] = $line;
            });

        return view('AutoDeploy.Views.autodeploy', ['output' => $output, 'returnValue' => $returnValue]);
    }
}
