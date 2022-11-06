<?php

namespace App\Providers;

use App\Models\Category;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\Auth\AuthRepositoryInterface;
use App\Repositories\Contracts\CategoriesRepository;
use App\Repositories\MySql\MySqlCategoriesRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);

        $this->app->bind(CategoriesRepository::class, function () {
            return new MySqlCategoriesRepository(new Category());
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
