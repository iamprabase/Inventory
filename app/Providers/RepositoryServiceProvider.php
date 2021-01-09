<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */

    protected $repositories = [
      BaseContract::class => BaseRepository::class, 
      BrandContract::class => BrandRepository::class,
      CategoryContract::class => CategoryRepository::class,
      ProductContract::class => ProductRepository::class,
      SupplierContract::class => SupplierRepository::class,
      PurchaseOrderContract::class => PurchaseOrderRepository::class,
      StockTransferContract::class => StockTransferRepository::class,
      
    ];

    public function register()
    {
        foreach($this->repositories as $interface => $repository){
          $this->app->bind($interface, $repository);
        }
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
