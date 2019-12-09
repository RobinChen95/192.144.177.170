<?php
namespace app\index\controller;

use think\Controller;
use think\Validate;

class Register extends Controller
{
    public function index()
    {
    	return $this->fetch();
    } 
    public function signIn()
    {
    	$this->redirect(url('login/index'));
    }
    public function register()
    {    	
    	$param = input('post.');
      	 $rule = [
            'user'  =>  'require',
            'password'  =>  'require|min:6|confirm',
         ];
         $msg = [
            'user.require' => '用户名不能为空',
            'password.require' => '密码不能为空',
            'password.min' => '密码必须6位以上',
            'password.confirm' => '两次密码不一致',
        ];
      
        $testdata = [
            'user' => $param['user_name'],
			'password' => $param['user_pwd'],
			'password_confirm' => $param['confirm'],
        ];

		$validate = new Validate($rule,$msg);
            
        if(!$validate->check($testdata)){
            return $this->error($validate->getError());
        }

    	$data = [		//接受传递的参数
				'user_name' => $param['user_name'],
				'user_pwd' => md5($param['user_pwd']),
			    ];
			
		/*	Db('表名') 数据库助手函数*/
			if(Db('users') -> insert($data)){		//添加数据
				return $this->success('注册成功','signIn');	//成功后跳转  signIn 界面
			}else{
				return $this->error('注册失败');
			}
    }
}