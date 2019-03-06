<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use App\Http\Model\User;

class RegisterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function ispas_valid($pas){
        if (preg_match("/^\S*(?=\S{7,15})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $pas))
            return true;
        return false;
    }

    public function isMail_valid($mail){
        if (preg_match("/^[a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $mail))
            return true;
        return false;
    }

    public function is_namevalid($name){
        if (preg_match("/^\w+$/u", $name))
            return true;
        return false;
    }

    public function handle($request, Closure $next)
    {
//        if ($request[$user])
        $user = new User();
        $error = array();
        if (!$this->is_namevalid($request["username"])){ // check name and lastname
            $error['username'] = "Not valid";
        }
        if (!$this->is_namevalid($request["lastname"])){
            $error['lastname'] = "Not valid";
        }
        if (!$this->isMail_valid($request['email'])){ // check email
            $error['email'] =  "Not valid";
        }
        if ($request['password'] == $request['confirm_pas']){ // check password
            if (!$this->ispas_valid($request['password']))
                $error['pas'] =  "not valid";
        }
        else $error['pas'] = "do not match";
////        $lol = DB::table('users')->where('email', $request["email"])->value('email');
        if ($user->is_mail_exist($request["email"]))
            $error['email'] = "already used";
        if($error){
            return $error;
        }
        return $next($request);
    }
}
