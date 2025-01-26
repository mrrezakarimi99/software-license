<?php

namespace Sourceinja\LicenseManager;

use Illuminate\Support\ServiceProvider;

class LicenseManagerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/license.php', 'license');

        $this->app->singleton(LicenseChecker::class, function ($app) {
            return new LicenseChecker();
        });
    }

    public function boot()
    {
        $this->app['events']->listen('Illuminate\Console\Events\CommandStarting', function ($event) {
            $licenseChecker = app(LicenseChecker::class);

            if (!$licenseChecker->isLicenseValid()) {
                echo "License invalid or expired. Command execution stopped.\n";
                exit(1);
            }
        });
    }
}