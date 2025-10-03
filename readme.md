# Laravel Like

[![Latest Version on Packagist](https://img.shields.io/packagist/v/stevecreekmore/laravel-like.svg?style=flat-square)](https://packagist.org/packages/stevecreekmore/laravel-like)
[![Total Downloads](https://img.shields.io/packagist/dt/stevecreekmore/laravel-like.svg?style=flat-square)](https://packagist.org/packages/stevecreekmore/laravel-like)

A simple Laravel package for liking and unliking users.

## Requirements
- Laravel 11 or greater.
- Laravel `User` model.

## Installation

Via Composer

``` bash
$ composer require stevecreekmore/laravel-like
```

Import LaravelLike into your User model and add the trait.

```php
namespace App\Models;

use stevecreekmore\LaravelLike\LaravelLike;

class User extends Authenticatable
{
    use LaravelLike;
}
```

Then run migrations.

```
php artisan migrate
```

## Usage

Like a user.
```php
auth()->user()->like($user);
```

Unlike a user.
```php
auth()->user()->unlike($user);
```

Check if a user is liking another user.
```php
@if (auth()->user()->isLiking($user))
    You are liking this user.
@endif
```

Check if a user is liked by another user.
```php
@if (auth()->user()->isLikedBy($user))
    This user is liking you.
@endif
```

Returns the users a user is liking.
```php
auth()->user()->getLiking();
```

Returns the users who are liking a user.
```php
auth()->user()->getLikers();
```

Returns an array of IDs of the users a user is liking.
```php
auth()->user()->getLikingIds();
```

Returns an array of IDs of the users who are liking a user.
```php
auth()->user()->getLikersIds();
```

Returns an array of IDs of the users a user is liking, and who is liking a user
```php
auth()->user()->getLikingAndLikersIds()
```


## Testing

``` bash
$ composer test
```

## License

MIT. Please see the [license file](license.md) for more information.

