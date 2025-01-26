<?php

namespace Sourceinja\LicenseManager;

use Illuminate\Support\Facades\Http;

class LicenseChecker
{
    /**
     * @throws \Exception
     */
    public function isLicenseValid(): bool
    {
        $licenseKey = config('license.license_key');
        $domain = config('app.url');

        if (empty($licenseKey)) {
            throw new \Exception('License key is not set.');
        }

        if (empty($domain)) {
            throw new \Exception('Domain is not set.');
        }

        $response = Http::post(config('license.server_url'), [
            'license_key' => $licenseKey,
            'domain' => $domain,
        ]);

        if ($response->successful() && $response->json('status') === 'valid') {
            return true;
        }

        throw new \Exception('License invalid or expired.');
    }
}