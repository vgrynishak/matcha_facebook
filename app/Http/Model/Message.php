<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-03-16
 * Time: 20:05
 */

namespace App\Http\Model;
use Illuminate\Support\Facades\DB;

class Message
{
    private $message;

    public function __construct()
    {
        $this->message = DB::table('messages');
    }
}