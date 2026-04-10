# Laravel Repository Package — Laravel 10+ Modernisation

## Goal

Update `programic/laravel-repository` from Laravel 5.8+/PHP 7.2 to Laravel 10/11/12/13 with PHP 8.1+ modern syntax, improved error handling, and tests.

## Composer.json

### Dependencies

```json
{
  "require": {
    "php": "^8.1",
    "illuminate/support": "^10.0|^11.0|^12.0|^13.0",
    "illuminate/database": "^10.0|^11.0|^12.0|^13.0",
    "illuminate/console": "^10.0|^11.0|^12.0|^13.0"
  },
  "require-dev": {
    "orchestra/testbench": "^8.0|^9.0|^10.0|^11.0",
    "phpunit/phpunit": "^10.0|^11.0"
  }
}
```

### Scripts

```json
{
  "scripts": {
    "test": "vendor/bin/phpunit"
  }
}
```

## BaseRepository

### Current issues
- `$arguments` passed as single array instead of spread (`->$name($arguments)` should be `->$name(...$arguments)`)
- No typed properties or return types
- Generic `\Exception` thrown when model not found
- PHPDoc incomplete

### Changes
- Typed property: `protected ?string $model = null`
- Add return types to all methods
- Fix argument spreading: use `...$arguments` in both `__call` and `__callStatic`
- `getModel()` return type: `\Illuminate\Database\Eloquent\Model`
- Replace `\Exception` with `\RuntimeException` with clearer message
- Improve `@mixin` PHPDoc for IDE support

## RepositoryInterface

- Keep empty as marker interface — no method signatures. Enforcing methods would conflict with the magic forwarding pattern.

## Repository

- Use constructor promotion: `public function __construct(protected Application $app)`

## RepositoryServiceProvider

- Add `void` return types on `boot()` and `register()`

## MakeRepositoryCommand

- Return type `int` on `handle()` (Laravel 9+ convention, returns `Command::SUCCESS`)
- Inject `Illuminate\Filesystem\Filesystem` via constructor instead of using `File` facade
- Update stub to use modern PHP syntax

### Updated stub
```php
<?php

namespace App\Repositories;

use Programic\Repository\BaseRepository;

class REPOSITORY_NAME extends BaseRepository
{
    //
}
```

## PHPUnit Config

Upgrade to PHPUnit 10+ format:
- Remove deprecated attributes: `convertErrorsToExceptions`, `convertNoticesToExceptions`, `convertWarningsToExceptions`, `backupStaticAttributes`, `verbose`
- Keep: `colors`, `processIsolation`, `stopOnFailure`, `backupGlobals`
- Update schema location

## Tests

Using Orchestra Testbench for Laravel package testing.

### Test structure
```
tests/
  TestCase.php              — Base test case with Testbench setup
  BaseRepositoryTest.php    — Model resolution + query forwarding
  MakeRepositoryCommandTest.php — Artisan command test
```

### Test cases

**BaseRepositoryTest:**
- Model auto-resolution from class name convention (e.g. `UserRepository` -> `\App\Models\User`)
- Explicit `$model` property override works
- Query method forwarding via `__call` with correct argument spreading
- `__callStatic` forwarding
- RuntimeException thrown when model cannot be found

**MakeRepositoryCommandTest:**
- Command creates file in `app/Repositories/`
- File contains correct class name and namespace
- Directory is created if it doesn't exist

## Files changed

1. `composer.json` — dependencies, scripts
2. `src/BaseRepository.php` — typed properties, return types, argument fix, better exceptions
3. `src/Repository.php` — constructor promotion
4. `src/RepositoryInterface.php` — no changes (keep as-is)
5. `src/RepositoryServiceProvider.php` — return types
6. `src/Commands/MakeRepositoryCommand.php` — return type, DI, modern syntax
7. `stubs/repository.php.stub` — minor formatting
8. `phpunit.xml.dist` — PHPUnit 10+ format
9. `README.md` — update version requirements
10. `tests/TestCase.php` — new file
11. `tests/BaseRepositoryTest.php` — new file
12. `tests/MakeRepositoryCommandTest.php` — new file
