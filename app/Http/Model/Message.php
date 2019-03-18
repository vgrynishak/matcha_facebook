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
   public static function add_msg($chat_id, $user_id, $message){
       return DB::table('messages')->insert(
           [
              'chat_id'=>$chat_id,
              'user_id'=>$user_id,
              'message'=>$message
           ]
       );
   }

    public static function get_msg($chat_id){
        return  DB::table('messages')->select('user_id', 'message', 'created_at')->where('chat_id', $chat_id)->get();
    }
}