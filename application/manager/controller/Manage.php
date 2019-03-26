<?php
namespace app\manager\controller;

use think\Controller;
use think\View;

class Manage extends Controller
{
    public function index()
    {
        //数据库连接、查询
        //如果没有则访问api并存储
        $user_name = session('user_name');
        if(empty($user_name)){
          	echo "您好，请登录<br/>";
            $this->redirect(url('login/index'));
        }else{
          	$res1 = db("application_form")->where("status",1)->count();
          	$res2 = db("application_form")->where("status",2)->whereor('status', 3)->count();
          	$res3 = db("application_form")->where("status",4)->whereor('status', 5)->count();
          	$res4 = db("car_license")->where("isvalid",1)->where('status', 1)->count();
          	$set = db("setting")->select();
            $view = new View();
          	$view->data = [
            	"r1" => $res1,
            	"r2" => $res2,
            	"r3" => $res3,
            	"r4" => $res4,
            ];
          	$view->set = $set;
        	return $view->fetch();
        }
    }
}