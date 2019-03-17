<?php

namespace App\Http\Model;
use Illuminate\Support\Facades\DB;

class Photo
{
    /**
     * User constructor.
     */

    private $photo;

    public function __construct()
    {
        $this->photo = DB::table('photos');
    }

    public function  add_new_photo($user_id, $patch){
        return $this->photo->insert([
            'patch'=>$patch,
            'user_id'=>$user_id,
        ]);
    }

    public function max_id(){
        return $this->photo->count();
    }
}