<?php
namespace app\manager\controller;

use think\View;
use think\Controller;

class CredentialSearch extends Controller
{
  
  	//车证查询界面的访问函数
    public function index()
    {
      	//通过session获取用户名
        $user_name = session('user_name');
      
      	//验证登录状态
        if(empty($user_name)){
          	echo "您好，请登录<br/>";
            $this->redirect(url('login/index'));
        }else{
          	//获取空界面
            $view = new View();
          
          	//获取完整车证
          	$view->data = db('car_license')->where("isvalid", 1)->select();
          	
          	//重定向
        	return $view->fetch();
        }
    }
  
  	//查询具体界面的访问函数
    public function trial($id)
    {
      	//通过session获取用户名
        $user_name = session('user_name');
      
      	//验证登录状态
        if(empty($user_name)){
          	echo "您好，请登录<br/>";
            $this->redirect(url('login/index'));
        }else{
          	//获取空界面
            $view = new View();
          
          	//获取完整车证的具体信息
            $view->data = db('car_license')->where('id',$id)->find();
          	
          	//重定向
            return $view->fetch('more');
        }
    }
}