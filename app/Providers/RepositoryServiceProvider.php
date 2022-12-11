<?php

namespace App\Providers;

use App\Models\Address;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\Auth\AuthRepositoryInterface;
use App\Repositories\Contracts\OrdersRepository;
use App\Repositories\Contracts\ServicesRepository;
use App\Repositories\Contracts\AddressesRepository;
use App\Repositories\Contracts\UsersRepository;
use App\Repositories\MySql\MySqlAddressesRepository;
use App\Repositories\MySql\MySqlOrdersRepository;
use App\Repositories\MySql\MySqlServicesRepository;
use App\Repositories\MySql\MySqlUsersRepository;
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

        $this->app->bind(ServicesRepository::class, function () {
            return new MySqlServicesRepository(new Service());
        });

        $this->app->bind(OrdersRepository::class, function () {
            return new MySqlOrdersRepository(new Order());
        });

        $this->app->bind(AddressesRepository::class, function () {
            return new MySqlAddressesRepository(new Address());
        });

        $this->app->bind(UsersRepository::class, function () {
            return new MySqlUsersRepository(new User());
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
