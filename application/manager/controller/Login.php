<?php
namespace app\manager\controller;

use think\Controller;
use think\View;
use think\Validate;

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
    	
      	$pd = md5($param['user_pwd']);
        $npd = $pd . "pku";
      
    	// 验证密码
    	if($has['user_pwd'] != md5($npd)){
    		$this->error('用户名密码错误');
    	}
    	
    	// 记录用户登录信息
    	session('user_id', $has['id']); 
    	session('user_name', $has['user_name']);
    	
    	$this->redirect(url('manage/index'));
    }
  
  	public function register()
    {    	
    	$user_name = session('user_name');
        if(empty($user_name)){
          	echo "您好，请登录<br/>";
            $this->redirect(url('login/index'));
        }else{
            $view = new View();
            return $view->fetch('register');
        }
    }
  
    public function change()
    {
        $user_name = session('user_name');
        if(empty($user_name)){
          	echo "您好，请登录<br/>";
            $this->redirect(url('login/index'));
        }else{
            $view = new View();
            return $view->fetch('change');
        }
    }
  
  	public function setting()
    {
        $user_name = session('user_name');
        if(empty($user_name)){
          	echo "您好，请登录<br/>";
            $this->redirect(url('login/index'));
        }else{
            $view = new View();
          	$view->data = db('setting')->select();
          	$view->major = db('major')->where("isvalid",1)->select();
          	$view->depart = db('department')->where("isvalid",1)->select();
            return $view->fetch('setting');
        }
    }
  
    public function loginOut()
    {
    	session('user_id', null);
    	session('user_name', null);
    	
    	$this->redirect(url('login/index'));
    }
  
    public function changePwd()
    {
    	//数据库连接、查询
        //如果没有则访问api并存储
        $user_name = session('user_name');
        if(empty($user_name)){
          	echo "您好，请登录<br/>";
            $this->redirect(url('login/index'));
        }else{
            $param = input('post.');
            $rule = [
                'oldpwd'  =>  'require',
                'password'  =>  'require|min:9|confirm:password_confirm',
            ];
            $msg = [
                'oldpwd.require' => '旧密码不能为空',
                'password.require' => '新密码不能为空',
                'password.min' => '密码必须9位以上',
                'password.comfirm' => '两次密码不一致',
            ];
          	$testdata = [
                'oldpwd' => $param['oldpwd'],
                'password' => $param['newpwd'],
                'password_confirm' => $param['comfirm'],
            ];
			$validate = new Validate($rule,$msg);
          	if(!$validate->check($testdata)){
                return json($testdata);
                return $this->error($validate->getError());
            }
          
    		$has = db('users')->where('user_name', $user_name)->find();
          
            $pd = md5($param['oldpwd']);
            $npd = $pd . "pku";
          
          	if($has['user_pwd'] != md5($npd)){
                $this->error('密码错误');
            }
          
          	$data = [		
				'user_name' => $user_name,
			];
          	$newdata = [		
				'user_pwd' => md5($param['newpwd']),
			];
          
          	$res = db('users') -> where($data) -> update($newdata);
            if($res != 0){
                session('user_id', null);
                session('user_name', null);
                $this->success('修改密码成功', 'login/index');
            }else
                $this->error('修改密码失败');
        }
    }
  	
  	public function changeSet()
    {
        $user_name = session('user_name');
        if(empty($user_name)){
          	echo "您好，请登录<br/>";
            $this->redirect(url('login/index'));
        }else{
            //需要修改
            $param = input('post.');
        	$res1 = 0;
        	$res2 = 0;
          	$res3 = 0;
          	if(in_array("Page2",$param)){
            	$id = 3;
                $postdata = [
                      'f1_access'=> (int)$param['f7_access'],
                      'f2_access'=> (int)$param['f8_access'],
                      'f3_access'=> (int)$param['f9_access'],
                      'valid_year'=> (int)$param['year'],
                ];
            }else if(in_array("Page1",$param)){
              	if($param["deleteid"] != ""){
              		$res1 = db('major') -> where("id",(int)$param["deleteid"]) -> update(["isvalid" => 0,]);
                }
              	if($param["addmajor"] != ""){
                  	$rs =   db('major') -> where(["major" => $param["addmajor"]]) ->select();
                    if(count($rs)!=0){
              			$res2 = db('major') -> where(["major" => $param["addmajor"],"isvalid" => 0,]) ->update(["isvalid" => 1,]);
                    }else{
                    	$res2 = db('major') -> insert(["major" => $param["addmajor"],]);
                    }
                }
            	$id = 2;
                $postdata = [
                      'f1_access'=> (int)$param['f4_access'],
                      'f2_access'=> (int)$param['f5_access'],
                      'f3_access'=> (int)$param['f6_access'],
                      'valid_year'=> (int)$param['year'],
                ];
            }elseif(in_array("Page0",$param)){
              	if($param["deleteid"] != ""){
              		$res1 = db('department') -> where("id",(int)$param["deleteid"]) -> update(["isvalid" => 0,]);
                }
              	if($param["addmajor"] != ""){
                  	$rs =   db('department') -> where(["department" => $param["addmajor"]]) ->select();
                    if(count($rs)!=0){
              			$res2 = db('department') -> where(["department" => $param["addmajor"],]) ->update(["isvalid" => 1,]);
                    }else {
                    	$res2 = db('department') -> insert(["department" => $param["addmajor"],]);
                    }
                }
            	$id = 1;
                $postdata = [
                      'f1_access'=> (int)$param['f1_access'],
                      'f2_access'=> (int)$param['f2_access'],
                      'f3_access'=> (int)$param['f3_access'],
                      'valid_year'=> (int)$param['year'],
                ];
            }
            $post_form = [
                  'id'=>  $id,
            ];
            $res3 = db('setting') -> where($post_form) -> update($postdata);
            $res = $res1+$res2+$res3;
            if($res != 0)
                $this->success('成功修改'.$res."条数据", 'login/setting');
            else
                $this->error('未发生任何设置修改');
        }
    }
  	
  	public function addUser()
    {
    	$param = input('post.');
        $rule = [
          'user'  =>  'require',
          'password'  =>  'require|min:9|confirm',
        ];
        $msg = [
          'user.require' => '用户名不能为空',
          'password.require' => '密码不能为空',
          'password.min' => '密码必须6位以上',
          'password.confirm' => '两次密码不一致',
        ];
      
        $testdata = [
            'user' => $param['user_name'],
			'password' => $param['password'],
			'password_confirm' => $param['comfirm'],
        ];

		$validate = new Validate($rule,$msg);
            
        if(!$validate->check($testdata)){
            return $this->error($validate->getError());
        }
		
      	$pd = md5($param['password']);
        $npd = $pd . "pku";
      
    	$data = [		//接受传递的参数
            'user_real_name' => $param['user_real_name'],
            'user_name' => $param['user_name'],
            'user_pwd' => md5($npd),
        ];
			
		/*	Db('表名') 数据库助手函数*/
        if(Db('users') -> insert($data)){		//添加数据
          return $this->success('注册成功', 'manage/index');	
        }else{
          return $this->error('注册失败');
        }
    }
}