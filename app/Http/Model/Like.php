<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-03-14
 * Time: 13:38
 */

namespace App\Http\Model;
use Illuminate\Support\Facades\DB;

class Like
{
    private $like;

    public function __construct()
    {
        $this->like = DB::table('likes');
    }

    public static function is_like($from, $to){
        return DB::select(
            'SELECT * FROM likes WHERE like_from=? AND like_to=?',
            [$from,$to]
        );
//        return  $this->like->where('like_from',$from)->where('like_to', $to)->get();
    }

    public function add_new_like($from, $to){
        return $this->like->insert([
            'like_from'=> $from,
            'like_to'=>$to
        ]);
    }
}