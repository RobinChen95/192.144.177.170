<?php 
namespace app\api\controller;

use think\Controller;
use think\Db;

class Getdata extends Controller
{
  	//从数据库获取固定车证办理的插件数据
    public function all()
    {
    	$param = input('post.');
        $major = db("major")->where("isvalid",1)->select();
      	$fmajor = array("请选择");
        for($i=0; $i<count($major); $i++){
          	$fmajor[$i+1] = $major[$i]["major"];
        }
        $depart = db("department")->where("isvalid",1)->select();
      	$fdepart = array("请选择");
        for($i=0; $i<count($depart); $i++){
          	$fdepart[$i+1] = $depart[$i]["department"];
        }
        $plugin = db("plugin_content")->where("isvalid",1)->select();
      	$fplugin = array();
        for($i=0; $i<count($plugin); $i++){
          	$fplugin[$i] = ["title" => $plugin[$i]["title"],"content" => $plugin[$i]["content"],];
        }
        $data = [
            'major' => $fmajor,
            'depart' => $fdepart,
            'plugin' => $fplugin,
        ];
        return json($data);
    }
}