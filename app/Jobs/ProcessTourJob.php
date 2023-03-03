<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\File;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessTourJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected array $processData)
    {
    }

    public function handle()
    {
//        if ($this->batch()->cancelled()) {
//            // Determine if the batch has been cancelled...
//
//            return;
//        }

        $json = $this->pullAssets();
        $this->storeJsonInDb(config('app.website_db'), $json);

        echo 'Job handled! \r\n';
        Log::debug('Job handled!');
    }

    protected function pullAssets()
    {
        $assets = [];
        $this->storeAssets($assets);

        return $this->processData['json'];
    }

    protected function storeAssets($assets)
    {
        foreach ($assets as $asset) {
            $file = new File($asset);

            if ($file->extension() === 'jpg' || $file->extension() === 'png') {
                $this->createImageVariationsSizes($file);
            }
        }
    }

    protected function createImageVariationsSizes($image)
    {
        echo 'Image variations of sizes are created! \r\n';
        Log::debug('Image variations of sizes are created!');
    }

    protected function storeJsonInDb(string $dbName, $json)
    {
        if ($dbName !== 'WebsiteDB') {
            DB::connection($dbName)->table('json_data')
                ->insert([
                    'path' => $json['path'],
                    'content' => $json['json'],
                ]);
        }

        DB::table('json_datas')
            ->insert([
                'path' => \Str::random('15'),
                'content' => json_encode(['some data']),
            ]);
    }
}
