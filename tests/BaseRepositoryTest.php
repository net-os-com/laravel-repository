<?php

namespace NetOS\Repository\Tests;

use Illuminate\Database\Eloquent\Model;
use NetOS\Repository\BaseRepository;

class TestModel extends Model
{
    protected $table = 'test_models';
}

class ExplicitModelRepository extends BaseRepository
{
    protected ?string $model = TestModel::class;
}

class NonExistentModelRepository extends BaseRepository
{
    //
}

class BaseRepositoryTest extends TestCase
{
    public function test_explicit_model_forwards_to_builder(): void
    {
        $repository = new ExplicitModelRepository();
        $builder = $repository->newQuery();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Builder::class, $builder);
    }

    public function test_call_forwards_to_query_builder(): void
    {
        $repository = new ExplicitModelRepository();
        $builder = $repository->where('id', 1);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Builder::class, $builder);
    }

    public function test_call_static_forwards_to_query_builder(): void
    {
        $builder = ExplicitModelRepository::where('id', 1);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Builder::class, $builder);
    }

    public function test_arguments_are_spread_correctly(): void
    {
        $repository = new ExplicitModelRepository();
        $builder = $repository->where('id', '=', 1);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Builder::class, $builder);
    }

    public function test_throws_runtime_exception_when_model_not_found(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Model cannot be found');

        $repository = new NonExistentModelRepository();
        $repository->where('id', 1);
    }
}
