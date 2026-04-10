# Programic - Repositories

[![Latest Version on Packagist](https://img.shields.io/packagist/v/programic/laravel-repository.svg?style=flat-square)](https://packagist.org/packages/programic/laravel-repository)
![](https://github.com/programic/laravel-repository/workflows/Run%20Tests/badge.svg?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/programic/laravel-repository.svg?style=flat-square)](https://packagist.org/packages/programic/laravel-repository)

This package allows you to use Repositories and keeps the controllers clean

### Installation
This package requires PHP 8.2+ and Laravel 10, 11, 12, or 13.

```
composer require programic/laravel-repository
```

### Basic Usage
```bash
# Create Repository
php artisan make:repository UserRepository
```

```php
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController {

    public function index(Request $request, UserRepository $userRepository)
    {
        $userCollection = $userRepository->search($request)->get();
    }
    
} 
```


### Laravel Boost

This package includes [Laravel Boost](https://laravel.com/docs/boost) guidelines and skills. When you run `php artisan boost:install`, the repository guidelines and skills are automatically discovered and installed.

### Testing
```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security-related issues, please email [info@programic.com](mailto:info@programic.com) instead of using the issue tracker.

## Credits

- [Rick Bongers](https://github.com/rbongers)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
