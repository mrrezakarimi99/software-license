<?php

namespace Sourceinja\LicenseManager;

use Illuminate\Support\Facades\Http;

class LicenseChecker
{
    public function isLicenseValid(): bool
    {
        $licenseKey = config('license.license_key');
        $domain = config('app.url');

        if (empty($licenseKey)) {
            return false;
        }
        $response = Http::post(config('license.server_url'), [
            'license_key' => $licenseKey,
            'domain' => $domain,
        ]);

        if ($response->successful() && $response->json('status') === 'valid') {
            return true;
        }

        return false;
    }
}