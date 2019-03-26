<?php
namespace app\manager\controller;

use think\View;
use think\Controller;

class FinalTrial extends Controller
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
          	$view->data = db('application_form')->where('status',2)->select();
          	
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
            $view->plugin = db('plugin_content')->where('id',0)->find();
            $view->data = db('application_form')->where('status',2)->where('id',$id)->find();
            return $view->fetch('trial');
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
            $res = db('application_form')->where('status',2)->where('id',$id)->update(['status' => 4]);
            if($res != 0){
              	$data = db('application_form')->where('id',$id)->find();
                $t = strtotime('now');
                if($data['type'] == "教师"||$data['type'] == "教职工"||$data['type'] == "teacher"){
                	$res = db('setting')->where('id',1)->find();
                }else if($data['type'] == "学生"||$data['type'] == "student"){
                	$res = db('setting')->where('id',2)->find();
                }else{
                	$res = db('setting')->where('id',3)->find();
            	}
          		$n = $res['valid_year'];
                $postdata = [
                      'type'=> $data['type'],
                      'usr_name' => $data['usr_name'],
                      'usr_number' => $data['usr_number'],
                      'department' => $data['department'],
                      'usr_phone' => $data['usr_phone'],
                      'car_number' => $data['car_number'],
                      'car_owner' => $data['car_owner'],
                      'car_card' => $data['car_card'],
                      'usr_card' => $data['usr_card'],
                      'other_img' => $data['other_img'],
                      'pass_date' => date('Y-m-d H:i:s',$t),
                      'valid_date' => date('Y-m-d H:i:s',$t+365*24*60*60*$n),
                  	
                ];
                db('car_license')->insert($postdata);
                $this->success('修改成功', 'final_trial/index');
            }
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
            $res=db('application_form')->where('status',2)->where('id',$id)->update(['status' => 5]);
            if($res != 0)
                $this->success('修改成功', 'final_trial/index');
            else
                $this->error('修改失败');
        }
    }
}