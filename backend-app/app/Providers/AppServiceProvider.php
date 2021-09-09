<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Builders\Order\OrderBillingAddressModelBuilder;
use App\Builders\Order\OrderShippingAddressModelBuilder;
use App\Contracts\Repositories\Order\OrderBillingAddressRepositoryInterface;
use App\Contracts\Repositories\Order\OrderItemRepositoryInterface;
use App\Contracts\Repositories\Order\OrderShippingAddressRepositoryInterface;
use App\Contracts\Repositories\PersistableRepositoryInterface;
use App\Contracts\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Order\OrderBillingAddressRepository;
use App\Repositories\Order\OrderitemRepository;
use App\Repositories\Order\OrderShippingAddressRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Order\OrderRepository;
use App\Contracts\Repositories\Order\OrderRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );

        $this->app->bind(
            OrderItemRepositoryInterface::class,
            OrderitemRepository::class
        );

        $this->app->bind(
            OrderShippingAddressRepositoryInterface::class,
            OrderShippingAddressRepository::class
        );

        $this->app->bind(
            OrderBillingAddressRepositoryInterface::class,
            OrderBillingAddressRepository::class
        );

        $this->app->when(OrderShippingAddressModelBuilder::class)
            ->needs(PersistableRepositoryInterface::class)
            ->give(OrderShippingAddressRepositoryInterface::class);

        $this->app->when(OrderBillingAddressModelBuilder::class)
            ->needs(PersistableRepositoryInterface::class)
            ->give(OrderBillingAddressRepositoryInterface::class);

        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
    }

    /**
     * @inheritDoc
     */
    public function boot()
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}
