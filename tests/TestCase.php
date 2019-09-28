<?php

namespace Envant\Likes\Tests;

use Envant\Likes\Tests\Models\Post;
use Envant\Likes\Tests\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /** @var User */
    protected $testUser;

    /** @var Post */
    protected $testPost;

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);

        $this->actingAs($this->testUser);
    }

    /**
     * Set up the environment.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['path.base'] = __DIR__.'/../src';

        // set default config
        $config = include __DIR__.'/../config/likes.php';
        foreach ($config as $param => $value) {
            $app['config']->set('likes.'.$param, $value);
        }

        // set up the database
        $app['config']->set('auth.providers.users.model', User::class);
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set(
            'database.connections.sqlite',
            [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ]
        );
    }

    /**
     * Set up the database.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase($app)
    {
        $this->loadMigrationsFrom([
            '--database' => 'sqlite',
            '--realpath' => realpath(__DIR__.'/../migrations'),
        ]);
        $this->loadLaravelMigrations(['--database' => 'sqlite']);

        $this->app['db']->connection()->getSchemaBuilder()->create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('body');
            $table->timestamps();
        });

        $this->testUser = User::create([
            'name' => 'Apple',
            'email' => 'appleseed@example.org',
            'password' => 'apple',
        ]);

        $this->testPost = Post::create([
            'body' => 'body',
        ]);
    }
}
