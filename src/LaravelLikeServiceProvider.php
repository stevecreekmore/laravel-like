<?php

namespace stevecreekmore\LaravelLike;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use stevecreekmore\LaravelLike\Commands\LaravelLikeCommand;

class LaravelLikeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-like')
            ->hasConfigFile()
            ->hasMigration('create_laravel_like_table');
    }
}
