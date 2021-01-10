<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\BaseController;

class ReportController extends BaseController
{
  
  public function __construct(){
    
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $total_product_count = Product::sum('available_quantity');
      $cost_value_total_stock = Product::sum('price');
      $product_below_threshold = Product::whereColumn('available_quantity', '<=', 'quantity_level_reminder')->get()->count();
      $categories = Category::all()->pluck('name', 'id')->toArray();
      $products = Product::all()->pluck('name', 'id')->toArray();
      $this->setPageTitle('Stock Analyzer Report', 'In Hand Product Report');
      
      return view('admin.reports.index', compact('total_product_count','product_below_threshold', 'cost_value_total_stock', 'categories', 'products'));
    }

    public function purchaseHistoryReport()
    {
      $products = Product::all()->pluck('name', 'id')->toArray();
      $suppliers = Supplier::all()->pluck('name', 'id')->toArray();
      $this->setPageTitle('Purchase Histroy Report', 'Purchase Histroy Report');
      
      return view('admin.reports.purchase-history', compact('products','suppliers'));
    }

    public function getCategoryProducts(Request $request){
      if($request->id){
        $category = Category::find($request->id);
  
        $products = $category->products->toArray();

      }else{
        $products = Product::all()->toArray();
      }

      return response()->json([
        "data" => $products
      ], 200);
    }

    public function getPurchaseHistoryReport(Request $request){
      $start_date = $request->start_date;
      $end_date = $request->end_date;
      $product_id = $request->product_id;
      $supplier_id = $request->supplier_id;
      
      $purchaseOrders = PurchaseOrder::whereBetween('purchase_orders.purchase_date', [$start_date, $end_date])
                        ->leftJoin('purchase_order_details', 'purchase_order_details.purchase_order_id', 'purchase_orders.purchase_date')
                        ->leftJoin('products', 'purchase_order_details.product_id', 'products.id')
                        ->leftJoin('suppliers', 'suppliers.id', 'purchase_orders.supplier_id')
                        ->where(function($q) use($product_id, $supplier_id){
                          if($supplier_id) $q->where('suppliers.id', $supplier_id);
                          if($product_id) $q->where('purchase_order_details.product_id', $product_id);
                        })->groupBy('purchase_orders.purchase_date')
                        ->select('purchase_orders.purchase_date', DB::raw('count(*) as num_purchase'), DB::raw('sum(grand_total_amount) as grand_total_amount') )
                        ->get();
      
      return response()->json([
        "data" => $purchaseOrders
      ], 200);
    }

    public function getReport(Request $request){
      $category_id = $request->category_id;
      $product_id = $request->product_id;
      if($category_id && !$product_id){
        $products = Product::whereHas('category', function ($query) use ($category_id) {
                      $query->where('categories.id', $category_id);
                    })->get()->toArray();
      }elseif($category_id && $product_id){
        $products = Product::whereId($product_id)->whereHas('category', function ($query) use ($category_id) {
                      $query->where('categories.id', $category_id);
                    })->get()->toArray();
      }elseif(!$category_id && !$product_id){
        $products = Product::all()->toArray();
      }elseif(!$category_id && $product_id){
        $products = Product::whereId($product_id)->get()->toArray();
      }
      
      return response()->json([
        "data" => $products
      ], 200);
    }
}
