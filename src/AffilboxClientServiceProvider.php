<?php

namespace JakubOrava\AffilboxClient;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use JakubOrava\AffilboxClient\Commands\AffilboxClientCommand;

class AffilboxClientServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('affilbox-client')
            ->hasConfigFile();
    }
}
