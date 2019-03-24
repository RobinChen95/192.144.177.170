<?php
namespace app\manager\controller;

use think\View;
use think\Controller;
use think\Model;
use think\Db;

class GodHand extends Controller
{
    public function add()
    {
        //数据库连接、查询
        //如果没有则访问api并存储
        $user_name = session('user_name');
        if(empty($user_name)){
          	echo "您好，请登录<br/>";
            $this->redirect(url('login/index'));
        }else{
            $view = new View();
          
        	return $view->fetch('add');
        }
    }
  	
  	//处理管理员添加车证的函数
  
  	public function doAdd(){
      
            $param = input('post.');
      		//左边是wjj，右边是wwr
      		$post_data_add = [
              'usr_name'=>$param['user_name'],
              'type'=>$param['sex1'],
              'usr_number'=>$param['user_num'],
              'usr_phone'=>$param['usr_phone'],
              'car_number'=>$param['car_number'],
              'department'=>$param['user_department'],
              'pass_date'=>date('Y-m-d H:i:s',time()),
              'car_owner'=>$param['owner'],
              'note'=>$param['note'],
              'isvalid'=>0,
            ];
      		//采用先传图片，再更新的方法，可能有隐患
      		$find_pic_to_add =[
              'usr_name'=>"",
              'isvalid'=>0,
            ];
            $res = Db::name('car_license') -> insert($post_data_add);
      		if($res != 0)
                $this->success('修改成功', 'manage/index');
            else
                $this->error('修改失败');
          	//return json($param);
    } 
      
    public function loss()
    {
        //数据库连接、查询
        //如果没有则访问api并存储
        $user_name = session('user_name');
        if(empty($user_name)){
          	echo "您好，请登录<br/>";
            $this->redirect(url('login/index'));
        }else{
            $view = new View();
          	
        	return $view->fetch('loss');
        }
    }
    public function invalid()
    {
        //数据库连接、查询
        //如果没有则访问api并存储
        $user_name = session('user_name');
        if(empty($user_name)){
          	echo "您好，请登录<br/>";
            $this->redirect(url('login/index'));
        }else{
            $view = new View();
          	
        	return $view->fetch('invalid');
        }
    }
    public function carappoint()
    {
        //数据库连接、查询
        //如果没有则访问api并存储
        $user_name = session('user_name');
        if(empty($user_name)){
          	echo "您好，请登录<br/>";
            $this->redirect(url('login/index'));
        }else{
            $view = new View();
          	
        	return $view->fetch('carappoint');
        }
    }
    public function peopleappoint()
    {
        //数据库连接、查询
        //如果没有则访问api并存储
        $user_name = session('user_name');
        if(empty($user_name)){
          	echo "您好，请登录<br/>";
            $this->redirect(url('login/index'));
        }else{
            $view = new View();
          	
        	return $view->fetch('peopleappoint');
        }
    }
}