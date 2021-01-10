<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\StockTransfer;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Repositories\Admin\PurchaseOrderRepository;
use App\Http\Repositories\Admin\StockTransferRepository;

class DashboardController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $stockTransferRepository;
    protected $purchaseOrderRepository;
    public function __construct(StockTransferRepository $stockTransferRepository,PurchaseOrderRepository $purchaseOrderRepository)
    {
        $this->middleware('auth:admins');
        $this->stockTransferRepository =  $stockTransferRepository;
        $this->purchaseOrderRepository =  $purchaseOrderRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $purchase_orders_count = PurchaseOrder::count();
      $products_count = Product::count();
      $suppliers_count = Supplier::count();
      $stock_transfers_count = StockTransfer::count();

      $stock_transfers = $this->stockTransferRepository->listTopStockTransferWithSourceDestination('id', 'desc', 5, ['*'])->toArray();
      
      $purchase_orders = $this->purchaseOrderRepository->listTopPurchaseOrderWithSupplier('id', 'desc', 5, ['*'])->toArray();
      
      $contexts = [
        'purchase_orders_count' => $purchase_orders_count,
        'products_count'         => $products_count,
        'suppliers_count'     => $suppliers_count,
        'stock_transfers_count' => $stock_transfers_count,
        'stock_transfers'     => $stock_transfers,
        'purchase_orders'     => $purchase_orders
      ];

      $this->setPageTitle('Dashboard', 'Home');
      
      return view('admin.dashboard.home', $contexts);
    }
}
