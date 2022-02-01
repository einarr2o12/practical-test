<?php

namespace App\Providers;

use App\Repositories\UserDetailRepository;
use App\Repositories\UserDetailRepositoryInterface;
use Illuminate\Support\ServiceProvider;

/**
 * Class BindUserDetailServiceProvider
 */
class BindUserDetailServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            UserDetailRepositoryInterface::class,
            UserDetailRepository::class
        );
    }
}
