<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-03-05
 * Time: 15:58
 */

namespace App\Http\Controllers;
use App\Events\Event;
use App\Listeners\ExampleListener;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Model\User;

class UserController extends Controller
{
    /**
     *
     */
    public function index(Request $request){
        if ($request->session()->has('id')) {
            $data['id'] = $request->session()->get('id');
            return view('main', ['data' => $data]);
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

}