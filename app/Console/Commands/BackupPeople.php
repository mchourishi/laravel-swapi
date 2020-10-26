<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use App\Http\Services\SwapiLog;


class BackupPeople extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup_people {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Take Backup of swapi characters table.';

    /**
     * Table to Backup
     * @var string
     */
    protected $table = 'swapi_characters';

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
     * @param string
     * @return int
     */
    public function handle()
    {
        $filename = $this->argument('filename');

        $process = new Process(array(
            'mysqldump',
            '--user='.getenv('DB_USERNAME'),
            '--password='.getenv('DB_PASSWORD'),
            getenv('DB_DATABASE'),
            $this->table,
        ));
        $process->run();
        if(!$process->isSuccessful()){
            SwapiLog::write('error', "Error running mysqldump command.");
            throw new ProcessFailedException($process);
        }else {
            // Store backup
            $store = Storage::put('backups/'.$filename, $process->getOutput());
            if($store == 1){
                SwapiLog::write('info', "Backup of {$this->table} stored.");
            }
        }
    }
}
