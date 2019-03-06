<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-03-05
 * Time: 20:50
 */

namespace App\Listeners;

use App\Events\onAdd;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class AddListener
{
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ExampleEvent  $event
     * @return void
     */
    public function handle(onAdd $event)
    {
        $event->last_name;
        $event->last_name;
    }
}