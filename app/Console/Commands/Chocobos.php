<?php

namespace App\Console\Commands;

use App\Http\Controllers\ChocobosController;
use Illuminate\Console\Command;

class Chocobos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:chocobos { nameFile }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to execute the use case proposed for the Chocobos ADN.';

    /**
     * Execute the console command.
     */
    public function handle(ChocobosController $chocobosController)
    {
        try {
            $this->line('');
            $this->line('');
            $this->line('');
            $this->line('-----------------    File is being processed    -----------------');
            $chocobosController->index($this->argument('nameFile'));
            $this->info('File created successfully');
        } catch (\Exception $e) {
            $this->error($e);
        }
    }
}
