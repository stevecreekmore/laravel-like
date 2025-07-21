<?php

namespace stevecreekmore\LaravelLike\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \stevecreekmore\LaravelLike\LaravelLike
 */
class LaravelLike extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \stevecreekmore\LaravelLike\LaravelLike::class;
    }
}
