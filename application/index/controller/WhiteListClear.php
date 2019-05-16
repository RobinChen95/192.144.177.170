<?php
namespace app\index\controller;

use think\Controller;
use think\View;


class WhiteListClear extends Controller
{
    public function index(){
            $list = db("whiteList")->where("isdelete",1)->select();
            $res = 0;
        foreach($list as $data){
                $postdata = [
                        "user" => "#".$data["user"],
                        "isdelete" => 0,
                        ];
                $cul = db("whiteList")->where("id",$data["id"])->update($postdata);
                $res += $cul;
        }

        return json($res);
    }
}
