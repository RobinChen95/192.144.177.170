<?php
namespace app\manager\controller;

use think\View;
use think\Controller;

class CarAppointSearch extends Controller
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
          	$view->data = db('car_appointment_form')->select();
          	
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
            $view->data = db('car_appointment_form')->where('status',1)->where('id',$id)->find();
            return $view->fetch('more');
        }
    }
        public function pass($id)
    {
        //数据库连接、查询
        //如果没有则访问api并存储
        $user_name = session('user_name');
        if(empty($user_name)){
          	echo "您好，请登录<br/>";
            $this->redirect(url('login/index'));
        }else{
            $view = new View();
            $res = db('application_form')->where('status',1)->where('id',$id)->update(['status' => 2]);
            if($res != 0)
                $this->success('修改成功', 'first_trial/index');
            else
                $this->error('修改失败');
        }
    }
      public function refuse($id)
    {
        //数据库连接、查询
        //如果没有则访问api并存储
        $user_name = session('user_name');
        if(empty($user_name)){
          	echo "您好，请登录<br/>";
            $this->redirect(url('login/index'));
        }else{
            $res=db('application_form')->where('status',1)->where('id',$id)->update(['status' => 3]);
            if($res != 0)
                $this->success('修改成功', 'first_trial/index');
            else
                $this->error('修改失败');
        }
    }
}