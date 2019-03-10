<?php
namespace app\manager\controller;

use think\Controller;

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
        	return $this->fetch();
        }
    }
}