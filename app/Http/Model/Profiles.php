<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-03-04
 * Time: 19:46
 */

namespace App\Http\Model;
use Illuminate\Support\Facades\DB;

class Profiles
{
    /**
     * User constructor.
     */

    private $pofile;

    public function __construct()
    {
        $this->profile = DB::table('profiles');
    }

    public  function is_user_have_profile($user_id){
        return $this->profile->select()->where('user_id',$user_id)->exists();
    }

    public function add_new_profile($gender, $pref, $biography, $interests, $patch, $user_id){
        return $this->profile->insert([
            'gender'=>$gender,
            'preferance'=>$pref,
            'biography'=>$biography,
            'interests'=>$interests,
            'avatar'=>$patch,
            'user_id'=>$user_id
        ]);
    }


    public function get_preferences($user_id){
        return $this->profile->select('preferance')->where('user_id',$user_id)->get('preferance');
    }

}