<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-03-14
 * Time: 13:50
 */

namespace App\Http\Model;
use Illuminate\Support\Facades\DB;

class Chat
{
    private $chat;

    public function __construct()
    {
        $this->chat = DB::table('chats');
    }

    public function add_new_chat(){
        return $this->chat->insertGetId([]);
    }

    public function check_chat($from, $to){
        return $this->chat
            ->where(function ($query) use($from, $to){
                $query->where('user_1', $from)
                    ->where('user_2', $to);
            })
            ->orWhere(function ($query) use ($from, $to){
                $query->where('user_1', $to)
                    ->where('user_2', $from);
        })->get();
    }

    public function get_all_chat($id){
//        return $this->chat->where('user_1', $id)
//            ->orWhere('user_2',$id)->get();
        return  $this->chat
            ->join('users', 'users.id', '=', 'user_1')
            ->join('users', 'users.id', '=', 'user_2')
            ->where('user_1', $id)
            ->orWhere('user_2',$id)
            ->get();
    }
}
