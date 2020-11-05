<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Order;
use App\StudentHaveOrders;
class CheckExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checkexpire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $order_time=StudentHaveOrders::where('has_paid',0)->get();
        $check=0;
        
        foreach($order_time as $order_time){
            if((strtotime(date('Y/m/d h:i:s'))-strtotime($order_time->created_at))/86400>=3){
                Order::where('order_id',$order_time->order_id)->update(['has_cancel'=>1]);
                $check=1;
            }
        }
        if($check){
            echo "有訂單過期";
        }
        else{
            echo "沒有訂單過期";
        }
    }
}
