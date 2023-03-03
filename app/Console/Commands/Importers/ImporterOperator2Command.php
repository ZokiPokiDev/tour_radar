<?php

namespace App\Console\Commands\Importers;

use Illuminate\Console\Command;

class ImporterOperator2Command extends Command
{
    protected $signature = 'solution:importer_2';
    protected $description = 'Download files (json, xml, ...) from operator 2 API';

    public function handle()
    {
        $this->info('Import from Operator 2 was successful!');
    }
}
