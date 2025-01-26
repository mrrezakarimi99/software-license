<?php

namespace Sourceinja\LicenseManager;

use Illuminate\Support\ServiceProvider;

class LicenseManagerServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/license.php', 'license');

        $this->app->singleton(LicenseChecker::class, function ($app) {
            return new LicenseChecker();
        });
    }

    public function boot()
    {
        $licenseChecker = app(LicenseChecker::class);
        try {
            if (!$licenseChecker->isLicenseValid()) {
                echo 'License invalid or expired.';
                exit;
            }
        }catch (\Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
}