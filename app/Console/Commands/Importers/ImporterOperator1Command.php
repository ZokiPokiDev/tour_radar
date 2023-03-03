<?php

namespace App\Console\Commands\Importers;

use App\Factories\TourFileStore;
use App\Factories\Transformers\JsonTransformer;
use App\Jobs\ProcessTourJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Throwable;

class ImporterOperator1Command extends Command
{
    public const OPERATOR_URL = 'https://poetrydb.org/title/Ozymandias/lines.json';

    protected $signature = 'solution:importer_1';
    protected $description = 'Download files (json, xml, ...) from operator 1 API';

    protected JsonTransformer $jsonTransformer;
    protected TourFileStore $tourFileStore;

    public function __construct(JsonTransformer $jsonTransformer, TourFileStore $tourFileStore)
    {
        parent::__construct();

        $this->jsonTransformer = $jsonTransformer;
        $this->tourFileStore = $tourFileStore;
    }

    public function handle()
    {
        $response = Http::get(self::OPERATOR_URL);

        $this->info('Successful get data from Operator 1 API!');
        Log::debug('Successful get data from Operator 1 API!');

        $transformedJson = $this->jsonTransformer->transform($response);
        $fileName = Str::random(10);

        $file = $this->tourFileStore->store($transformedJson, $fileName);

        if ($file['exist']) {
            $this->warn('Import from Operator 1 was successful! But file already exist in our system!');
            Log::warning('Import from Operator 1 was successful! But file already exist in our system!');
            return;
        }

        $this->info('Tour file was successful store!');
        Log::debug('Tour file was successful store!');

        // Dispatch job with Bus system
        //  Is not run with Bus, because need to implement Supervisor package/vendor
//        $this->dispatchJobWithBus($file, $transformedJson);

        ProcessTourJob::dispatch([
            'file' => $file['path'],
            'json' => $transformedJson,
            'assets_url' => '',
        ]);

        $this->info('Import from Operator 1 was successful!');
        Log::debug('Import from Operator 1 was successful!');
    }

    protected function dispatchJobWithBus($file, $transformedJson)
    {
        $batch = Bus::batch([
            new ProcessTourJob([
                'file' => $file['path'],
                'json' => $transformedJson,
                'assets_url' => '',
            ]),
        ])->then(function (Batch $batch) {
            // All jobs completed successfully...
            $this->info('All jobs completed successfully!');
            Log::debug('All jobs completed successfully!');
        })->catch(function (Batch $batch, Throwable $e) {
            // First batch job failure detected...
            $this->info('First batch job failure detected! Massage: ' . $e->getMessage());
            Log::debug('First batch job failure detected! Massage: ' . $e->getMessage());
        })->finally(function (Batch $batch) {
            // The batch has finished executing...
            $this->info('The batch has finished executing!');
            Log::debug('The batch has finished executing!');
        })->dispatch();

//        var_dump($batch->totalJobs, $batch->pendingJobs, $batch->failedJobs);
    }
}
