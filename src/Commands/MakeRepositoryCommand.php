<?php

namespace Programic\Repository\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeRepositoryCommand extends Command
{
    protected $signature = 'make:repository {repository}';

    protected $description = 'Create a new repository class';

    public function __construct(private Filesystem $filesystem)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $className = Str::studly($this->argument('repository'));
        $fileName = $className . '.php';

        $stub = $this->filesystem->get(__DIR__ . '/../../stubs/repository.php.stub');
        $stub = str_replace('REPOSITORY_NAME', $className, $stub);

        $path = base_path() . '/app/Repositories';

        $this->filesystem->isDirectory($path) or $this->filesystem->makeDirectory($path);
        $this->filesystem->put($path . '/' . $fileName, $stub);

        $this->line('<info>Repository created:</info> ' . $fileName);

        return self::SUCCESS;
    }
}
