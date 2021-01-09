<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Mail\SendLowStockAlert;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckProductStockCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:check_product_stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks Product Stocks and sends email if below certain level.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
      
      $checkProductsBelowMentionedLevel = Product::whereColumn('available_quantity', '<=', 'quantity_level_reminder')
                                          ->get(['name', 'sku', 'available_quantity'])
                                          ->toArray();

      try{
        Mail::to(env('MAIL_TO_ADDRESS', 'hello@example.com'))->send(new SendLowStockAlert($checkProductsBelowMentionedLevel));
      }catch(\Exception $e){
        Log::alert($e->getMessage());
      }

    }
}
