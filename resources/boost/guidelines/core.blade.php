## Programic Repository

This package provides the repository pattern for Laravel index endpoints. Repositories encapsulate list/overview query logic using Spatie QueryBuilder, keeping controllers clean.

### Creating a Repository

```bash
php artisan make:repository UserRepository
```

This creates a repository extending `BaseRepository` in `app/Repositories/`.

### Usage

Repositories contain query methods that use `QueryBuilder::for()` to build filtered, sorted, and paginated overview queries:

@verbatim
<code-snippet name="Repository for index endpoint" lang="php">
use App\Models\User;
use Programic\Repository\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class UserRepository extends BaseRepository
{
    public function fromRequest(PaginatedData $data): LengthAwarePaginator
    {
        return QueryBuilder::for(User::query())
            ->defaultSort(AllowedSort::field('id'))
            ->allowedIncludes(['roles', 'company'])
            ->allowedFilters([
                AllowedFilter::exact('company_id'),
            ])
            ->paginate(perPage: $data->limit, page: $data->page);
    }
}
</code-snippet>
@endverbatim

### Conventions

- Repositories live in `app/Repositories/`, optionally in subdirectories per domain
- One repository per model
- Repositories extend `Programic\Repository\BaseRepository`
- Repositories are only used for index/overview queries
- Use Spatie QueryBuilder for building filtered, sorted, and paginated queries
