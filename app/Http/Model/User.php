<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-03-04
 * Time: 19:46
 */

namespace App\Http\Model;
use Illuminate\Support\Facades\DB;

class User
{
    /**
     * User constructor.
     */

    private $user;

    public function __construct()
    {
        $this->user = DB::table('users');
    }

    public  function is_mail_exist($email){
//        self::user->get()
//        echo "here";
        return $this->user->where('email',$email)->value('email');
    }

    public function add_new_user($username, $lastname, $email, $pas, $url_activate){
        return $this->user->insert([
            'username'=>$username,
            'lastname'=>$lastname,
            'email'=>$email,
            'pas'=>$pas,
            'url_activate' =>$url_activate
        ]);
    }
    public function is_url_exist($url_activate){
        return $this->user->where('url_activate', $url_activate)->value('url_activate');
    }

    public function activate_by_url($url_activate){
        return $this->user->where('url_activate', $url_activate)->update(
            ['activate'=>'1']
        );
    }

    public function is_user_exist($email, $pas){
        return ($this->user->where('email', $email)->where('pas',  $pas)->exists())?1:0;
    }

    public function is_activate( $email){
        return ($this->user->where('email', $email)->value('activate'));
    }

    public function get_user_id($email){
        return $this->user->where('email', $email)->value('id');
    }
}