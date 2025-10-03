<?php

namespace stevecreekmore\LaravelLike\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use stevecreekmore\LaravelLike\LaravelLike;

class User extends Authenticatable
{
    use LaravelLike;

    public $timestamps = false;

    // this model is only to be used for running tests
}
