<?php

namespace JakubOrava\AffilboxClient;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class AffilboxClientServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('affilbox-client')
            ->hasConfigFile();
    }
}
