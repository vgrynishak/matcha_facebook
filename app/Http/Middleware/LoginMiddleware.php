<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-03-05
 * Time: 13:53
 */

namespace App\Http\Middleware;
use Illuminate\Support\Facades\DB;
use App\Http\Model\User;
use Closure;

class LoginMiddleware
{
    public function handle($request, Closure $next)
    {
//        if ($request[$user])
        $user = new User();
        $pas = hash('whirlpool', $request['password']);
        if (!($user->is_user_exist($request['email'], $pas)))
            return  'combination this email and password not found';
        if (!$user->is_activate($request['email']))
            return  "You don't activate your account";
        return $next($request);
    }
}