<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-03-06
 * Time: 17:22
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    public function boot(){
//        Broadcast::routes();
//        require base_path('routes/chanels.php');
    }
}