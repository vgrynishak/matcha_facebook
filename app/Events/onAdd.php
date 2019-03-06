<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-03-05
 * Time: 20:52
 */

namespace App\Events;


class onAdd extends Event
{
    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $user_name;
    public $last_name;

    public function __construct()
    {
        //
    }
}