<?php

namespace App\Console\Commands;

use App\Jobs\ImportUserJob;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImportUsersCommand extends Command implements ShouldQueue
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:users {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import users from a CSV file';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file = $this->argument('file');

        if (! Storage::disk('local')->exists($file)) {
            $this->error("File doesn't exist");

            return;
        }

        $file = Storage::disk('local')->path($file);
        $handle = fopen($file, 'r');

        if (! $handle) {
            $this->error('Error opening file');

            return;
        }

        $header = fgetcsv($handle, 0, ',');
        $total = count(file($file));
        $count = 0;
        DB::beginTransaction();
        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            $count++;
            $this->process($header, $row);
            $percent = ($count / $total) * 100;
            $this->output->write("\r");
            $this->output->write("Processed: $count/$total ($percent%)");
        }
        DB::commit();
        $this->output->write("\r");
        $this->info('Import completed');
    }

    public function process($header, $data)
    {
        $header = explode(';', $header[0]);
        $nameIndex = array_search('fullname', $header);
        $emailIndex = array_search('email', $header);

        if ($nameIndex !== false && $emailIndex !== false) {

            $row = explode(';', $data[0]);

            $user = User::where('email', $row[$emailIndex])->first();

            if (! $user) {
                $userData = [
                    'name' => $row[$nameIndex],
                    'email' => $row[$emailIndex],
                    'role_id' => 1,
                    'password' => 0,
                    'created_by' => 1,
                ];
                dispatch(new ImportUserJob($userData));
            }

        } else {
            $this->error("CSV file header doesn't match the required format");
        }
    }
}
