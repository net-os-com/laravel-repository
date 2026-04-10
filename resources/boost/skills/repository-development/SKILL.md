---
name: repository-development
description: Build and work with Programic Repository features. Use when creating repositories for index/overview endpoints, or implementing the repository pattern for list queries in Laravel. Use this skill whenever working with app/Repositories, BaseRepository, or when the user needs a filtered, sorted, paginated index query.
---

# Repository Development

## When to Use

Use this skill when:
- Creating new repository classes for index/overview endpoints
- Adding or modifying list query methods in repositories
- Building filtered, sorted, and paginated overview queries

## Rules

- Repositories are exclusively for index/overview queries (listing and filtering data)
- Repositories live in `app/Repositories/`, optionally in subdirectories per domain (e.g. `app/Repositories/User/UserRepository.php`)
- Every repository extends `Programic\Repository\BaseRepository`
- Create repositories with `php artisan make:repository {Name}Repository`
- Use Spatie QueryBuilder (`QueryBuilder::for()`) for building queries with filters, sorts, and includes

## Writing a Repository

Build query methods using `QueryBuilder::for(Model::query())`. A `fromRequest` method is the standard pattern — it accepts pagination data and returns a paginated result:

```php
use App\Models\User;
use Programic\Repository\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class UserRepository extends BaseRepository
{
    public function fromRequest(PaginatedData $data): LengthAwarePaginator
    {
        return QueryBuilder::for(User::query())
            ->defaultSort(AllowedSort::field('id'))
            ->allowedIncludes(['roles', 'company', 'teams'])
            ->allowedFilters([
                AllowedFilter::exact('company_id'),
                AllowedFilter::custom('query', new FullTextFilter(['first_name', 'last_name', 'email'])),
            ])
            ->paginate(perPage: $data->limit, page: $data->page);
    }
}
```

## Controller Integration

Inject the repository and call its query method from the index endpoint:

```php
class UserController
{
    public function index(PaginatedData $data, UserRepository $userRepository)
    {
        return $userRepository->fromRequest($data);
    }
}
```
