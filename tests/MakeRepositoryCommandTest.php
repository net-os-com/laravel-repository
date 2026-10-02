<?php

namespace NetOS\Repository\Tests;

use Illuminate\Support\Facades\File;

class MakeRepositoryCommandTest extends TestCase
{
    protected function tearDown(): void
    {
        $path = base_path('app/Repositories');

        if (File::isDirectory($path)) {
            File::deleteDirectory($path);
        }

        parent::tearDown();
    }

    public function test_command_creates_repository_file(): void
    {
        $this->artisan('make:repository', ['repository' => 'UserRepository'])
            ->assertSuccessful();

        $this->assertFileExists(base_path('app/Repositories/UserRepository.php'));
    }

    public function test_created_file_contains_correct_class_name(): void
    {
        $this->artisan('make:repository', ['repository' => 'OrderRepository'])
            ->assertSuccessful();

        $content = File::get(base_path('app/Repositories/OrderRepository.php'));

        $this->assertStringContainsString('class OrderRepository', $content);
        $this->assertStringContainsString('extends BaseRepository', $content);
        $this->assertStringContainsString('namespace App\Repositories', $content);
    }

    public function test_command_creates_repositories_directory_if_missing(): void
    {
        $path = base_path('app/Repositories');

        $this->assertDirectoryDoesNotExist($path);

        $this->artisan('make:repository', ['repository' => 'TestRepository'])
            ->assertSuccessful();

        $this->assertDirectoryExists($path);
    }
}
