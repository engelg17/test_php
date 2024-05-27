<?php

namespace App\Console\Commands;

use App\Http\Controllers\ChocoBillyController;
use Illuminate\Console\Command;

class ChocoBilly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:choco-billy { nameFile }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to execute the use case proposed for the Choco Billy business.';

    /**
     * Execute the console command.
     */
    public function handle(ChocoBillyController $chocoBillyController)
    {
        try {
            $this->line('');
            $this->line('');
            $this->line('');
            $this->line('-----------------    File is being processed    -----------------');
            $chocoBillyController->index($this->argument('nameFile'));
            $this->info('File created successfully');
        } catch (\Exception $e) {
            $this->error($e);
        }
    }
}
