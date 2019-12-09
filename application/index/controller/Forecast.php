<?php
namespace app\index\controller;

use think\Controller;

class Forecast extends Controller
{
    public function index()
    {
    	return $this->fetch();
    }       
    public function forecast()
    {
        $param = input('post.');
        if(empty($param['city'])){
    		
    		$this->error('城市名不能为空');
    	}
        cookie('city', $param['city'], 600);
    	$this->redirect(url('index/index'));
    }   
}
