<?php

namespace NetOS\Repository;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class BaseRepository implements RepositoryInterface
{
    protected ?string $model = null;

    public function __call(string $name, array $arguments): mixed
    {
        if (method_exists($this, $name)) {
            return $this->$name(...$arguments);
        }

        return $this->getModel()->query()->$name(...$arguments);
    }

    public static function __callStatic(string $name, array $arguments): mixed
    {
        $instance = new static();

        if (method_exists($instance, $name)) {
            return $instance->$name(...$arguments);
        }

        return $instance->getModel()->query()->$name(...$arguments);
    }

    private function getModel(): Model
    {
        if ($this->model !== null) {
            return new $this->model;
        }

        $className = substr(static::class, strrpos(static::class, '\\') + 1);
        $className = str_replace('Repository', '', $className);
        $model = '\App\Models\\' . $className;

        if (class_exists($model)) {
            $this->model = $model;

            return new $this->model;
        }

        throw new \RuntimeException('Model cannot be found: ' . $model);
    }
}
