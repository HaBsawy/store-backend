<?php

namespace App\Providers;

use App\Repository\Category\CategoryEloquent;
use App\Repository\Category\CategoryInterface;
use App\Repository\Client\ClientEloquent;
use App\Repository\Client\ClientInterface;
use App\Repository\Income\IncomeEloquent;
use App\Repository\Income\IncomeInterface;
use App\Repository\OutCome\OutcomeEloquent;
use App\Repository\OutCome\OutcomeInterface;
use App\Repository\Product\ProductEloquent;
use App\Repository\Product\ProductInterface;
use App\Repository\Purchase\PurchaseEloquent;
use App\Repository\Purchase\PurchaseInterface;
use App\Repository\Sale\SaleEloquent;
use App\Repository\Sale\SaleInterface;
use App\Repository\Supplier\SupplierEloquent;
use App\Repository\Supplier\SupplierInterface;
use App\Repository\User\UserEloquent;
use App\Repository\User\UserInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    private $repositories = [
        UserInterface::class        => UserEloquent::class,
        SupplierInterface::class    => SupplierEloquent::class,
        ClientInterface::class      => ClientEloquent::class,
        CategoryInterface::class    => CategoryEloquent::class,
        ProductInterface::class     => ProductEloquent::class,
        PurchaseInterface::class    => PurchaseEloquent::class,
        SaleInterface::class        => SaleEloquent::class,
        IncomeInterface::class      => IncomeEloquent::class,
        OutcomeInterface::class     => OutcomeEloquent::class
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->repositories as $interface => $eloquent) {
            $this->app->singleton($interface, $eloquent);
        }
    }
}
