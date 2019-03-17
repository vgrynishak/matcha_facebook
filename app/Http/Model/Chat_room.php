<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-03-16
 * Time: 20:03
 */

namespace App\Http\Model;
use Illuminate\Support\Facades\DB;

class Chat_room
{
    private $rooms;

    public function __construct()
    {
        $this->rooms = DB::table('c_rooms');
    }

    public function is_chat_exist($curent, $other){
        return DB::select(
            'SELECT new.user_id FROM c_rooms AS old INNER JOIN c_rooms AS new ON old.chat_id=new.chat_id WHERE old.user_id=? AND new.user_id = ?',
            [$curent, $other]
        );
    }

    public function add_new_chat($user1, $user2, $chat_id){
        return $this->rooms->insert(
            [
                [
                    'chat_id' => $chat_id,
                    'user_id' => $user1

                ],
                [
                    'chat_id' => $chat_id,
                    'user_id' => $user2

                ]
            ]
        );
    }

    public function get_all_chat($curent){
        return DB::select(
            'SELECT new.chat_id, new.user_id, lst_msg, username, avatar FROM c_rooms AS old INNER  JOIN  chats ON chats.chat_id=old.chat_id  INNER JOIN c_rooms AS new ON old.chat_id=new.chat_id  INNER JOIN profiles ON profiles.user_id = new.user_id INNER JOIN users ON users.id = new.user_id WHERE old.user_id=? AND NOT new.user_id = ? ',
            [$curent, $curent]
        );
    }
}