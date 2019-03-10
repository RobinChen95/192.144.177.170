<?php
namespace app\manager\controller;

use think\Controller;

class Login extends Controller
{
    public function index()
    {
    	return $this->fetch();
    }   
    public function doLogin()
    {
    	$param = input('post.');
    	if(empty($param['user_name'])){
    		
    		$this->error('用户名不能为空');
    	}
    	
    	if(empty($param['user_pwd'])){
    		
    		$this->error('密码不能为空');
    	}
    	
    	// 验证用户名
    	$has = db('users')->where('user_name', $param['user_name'])->find();
    	if(empty($has)){
    		
    		$this->error('用户名密码错误');
    	}
    	
    	// 验证密码
    	if($has['user_pwd'] != md5($param['user_pwd'])){
    		
    		$this->error('用户名密码错误');
    	}
    	
    	// 记录用户登录信息
    	session('user_id', $has['id']); 
    	session('user_name', $has['user_name']);
    	
    	$this->redirect(url('manage/index'));
    }
    public function loginOut()
    {
    	session('user_id', null);
    	session('user_name', null);
    	
    	$this->redirect(url('login/index'));
    }
}