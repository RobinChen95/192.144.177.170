<?php
namespace app\manager\controller;

use think\View;
use think\Controller;

class CredentialSearch extends Controller
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
            $view = new View();
          	$view->data = db('car_license')->where("isvalid", 1)->select();
          	
        	return $view->fetch();
        }
    }
    public function trial($id)
    {
        //数据库连接、查询
        //如果没有则访问api并存储
        $user_name = session('user_name');
        if(empty($user_name)){
          	echo "您好，请登录<br/>";
            $this->redirect(url('login/index'));
        }else{
            $view = new View();
            $view->data = db('car_license')->where('id',$id)->find();
            return $view->fetch('more');
        }
    }
}