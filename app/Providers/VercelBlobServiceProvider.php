<?php

namespace App\Providers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\FilesystemAdapter;
use League\Flysystem\Filesystem;
use App\Extensions\VercelBlobAdapter;
use VercelBlobPhp\Client;

class VercelBlobServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Storage::extend('vercel', function ($app, $config) {
            $client = new Client($config['token']);
            $adapter = new VercelBlobAdapter($client);

            return new FilesystemAdapter(
                new Filesystem($adapter, $config),
                $adapter,
                $config
            );
        });
    }
}
