<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-03-05
 * Time: 15:58
 */

namespace App\Http\Controllers;
use App\Events\Event;
use App\Http\Model\Message;
use App\Listeners\ExampleListener;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Model\User;
use App\Http\Model\Profiles;
use App\Http\Model\Photo;
use App\Http\Model\Like;
use App\Http\Model\Chat;
use App\Http\Model\Chat_room;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    /**
     *
     */
    private $user;
    private $profile;
    private $photo;
    private $like;
    private $chat;
    private $room;
    public function  __construct()
    {
        $this->user = new User();
        $this->profile = new Profiles();
        $this->photo = new Photo();
        $this->like = new Like();
        $this->chat = new Chat();
        $this->room = new Chat_room();
    }

    public function index(Request $request, $id = 0){
        if ($request->session()->has('id')) {
            if (!($this->profile->is_user_have_profile($request->session()->get('id')))) {
                $url_data =$this->user->get_user_info($request->session()->get('id'));
                return view('profile', ['url_data' => $url_data]);
            }
            else {
                if ($id == 0) {
                    $data = $this->user->get_all_info($request->session()->get('id'));
                    $my = 1;
                }
                else {
                    $data = $this->user->get_all_info($id);
                    if (!isset($data[0])) {
                        return abort('404');
                    }
//                    echo $id."vs";
//                    echo $this->profile->is_user_have_profile($id);
//                    $data = $this->user->get_all_info($id);
//                    print_r( $data);
                    $my = 2;
                }
                return view('main', ['data'=> $data, 'check'=>$my]);
            }
        }
        else
            return redirect()->route('home');
    }

    public function logout(Request $request){
        if ($request->session()->has('id')) {
            $request->session()->forget('id');
            return redirect()->route('home');
//            Event::fire(new ExampleListener());
        }
        else
            abort('404');
    }
    public function profile(Request $request){
        $img = str_replace(' ', '+', $request['avatar']);
        $img = base64_decode($img);
        $max_id = $this->photo->max_id() + 1;
        $path = 'image/'.$max_id.".png";
        $user_id = $request->session()->get('id');
        $this->photo->add_new_photo($user_id, $path);
        $this->profile->add_new_profile($request['gender'],$request['preferences'],$request['biography'],$request['intereses'], '/'.$path, $user_id);
        $this->user->update_username($user_id, $request['username']);
        $this->user->update_lastname($user_id, $request['lastname']);
        file_put_contents($path, $img);
        return ;
    }

    public function news(Request $request){
//        $preferance = $this->profile->get_preferences($request->session()->get('id'));
//        dd($preferance[0]->preferance);
       return view('news');
    }

    public function get_news(Request $request){
        $preferance = $this->profile->get_preferences($request->session()->get('id'));
        $prepare = ($preferance[0]->preferance == "Women")? 'Femail':'Male';
        $photo = $this->user->get_photo($prepare);
        return $photo;
    }

    public function like(Request $request){
        if (!$request->session()->has('id'))
            abort('404');
        $from = $request->session()->get('id');
        $to = $request['channels'];
//        echo $from.'vs'.$to;
        $chat = $this->room->is_chat_exist($from, $to);
        if (isset($chat[0]) || isset(Like::is_like($from, $to)[0]))
            return 'error';
        if (isset(Like::is_like($to, $from)[0]) ){
            $id = $this->chat->add_new_chat();
            $this->room->add_new_chat($from,$to,$id);
            $message = 'Вам відповіли взаємністю ви можете почати переписку!';
        }
        else
            $message = "Вам лайкнули фото,";
        $this->like->add_new_like($from, $to);
        $redis = Redis::connection('default');
        $data = [
            'message'=>$message,
        ];
        $redis->publish('like.'.$request['channels'], json_encode($data));
            return ;
    }

    public function get_id(Request $request){
        return $request->session()->get('id');
    }

    public function chats(){
        return view('chats');
    }

    public function get_chats(Request $request){
        $chat = $this->room->get_all_chat($request->session()->get('id'));
        return $chat;
    }

    public function message(Request $request){
//        return $request;
        $chat_id  =  $request['chat'];
        $user_id = $request->session()->get('id');
        $message = $request['message'];
        Message::add_msg($chat_id,$user_id,$message);
        Chat::add_lst_msg($message,$chat_id);
        $redis = Redis::connection('default');
        $data = [
            'message'=>$message,
        ];
        $redis->publish($request['channels'], json_encode($data));
        return $request;
//            event(new \App\Events\Event_to_chat($request['message']));
    }
    //
    public function get_messages(Request $request){
//        $chat = $this->room->get_all_chat($request->session()->get('id'));
//        print_r($result);
        return Message::get_msg($request['chat']);
//        return json_encode($result);
    }
}