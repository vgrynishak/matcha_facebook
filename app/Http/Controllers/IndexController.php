<?php

namespace App\Http\Controllers;

use App\Events\Message;
//namespace AppEvents;
//namespace App\Mail;

//use Illuminate\Mail\Mailable;
//use http\Env\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Model\User;
use Illuminate\Support\Facades\Redis;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function special_Message(){
        $string = "qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPLKJHGFDSAZXCVBNM65";
        $i = 0;
        $message = "";
        while ($i < 50){
            $k = rand(0, strlen($string) - 1);
            $message .= $string[$k];
            $i++;
        }
        return $message;
    }

    public function Send_mail($to, $message, $subject){
        $encoding = "utf-8";
        $subject_preferences = array(
            "input-charset" => "utf-8",
            "output-charset" => "utf-8",
            "line-length" => 76,
            "line-break-chars" => "\r\n"
        );
        $header = "Content-type: text/html; charset=" . $encoding . " \r\n";
        $header .= "From: vgrynishak@gmail.com \r\n";
        $header .= "MIME-Version: 1.0 \r\n";
        $header .= "Content-Transfer-Encoding: 8bit \r\n";
        $header .= "Date: ".date("r (T)")." \r\n";
        $header .= iconv_mime_encode("Subject", $subject, $subject_preferences);
        return (mail($to, $subject, $message, $header));
    }

    public function show(Request $request){
        if ($request->session()->has('id'))
            return redirect()->route('main');
        else
            return view('index');
    }


    public function register(Request $request){
//        return $request;
        $pas = hash('whirlpool',$request['password']);
        $url_activate = $this->special_Message();
        $message = "Hi, ".$request["username"]. "!\nPlease activate your account for " . "<a href=\"http://" . $_SERVER['HTTP_HOST'] . "/activate/" . $url_activate . "\">Підтведжую!</a>";
        $this->Send_mail($request["email"], $message, "Registration on site VG");
        $this->user->add_new_user($request['username'],$request['lastname'], $request['email'], $pas, $url_activate);
    }

    public function login(Request $request){
        $user = new User();
        $user_id = $user->get_user_id($request['email']);
        $request->session()->put('id', $user_id);
//        $_SESSION['id'] = $user_id;
//        echo $_SESSION['id'];
        return ; // не працює return true???????
    }

    public function activate($url_activate){
        if ($this->user->is_url_exist($url_activate)){
            $this->user->activate_by_url($url_activate);
            return redirect()->route('home');
        }
        else
            return abort(404);

    }
    public function db(Request $request){
        print_r( $request);
//        $pas = hash('whirlpool', req)
//        $this->user->add_new_user()
        //dd($result);
    }

}
