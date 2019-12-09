<?php
namespace app\index\controller;
use app\api\controller\City;
class Index
{
    public function index()
    {
        //数据库连接、查询
        //如果没有则访问api并存储
      
        $user_name = cookie('user_name');
        if(empty($user_name)){
          echo "您好，游客。<br/>";
        }else{
    	  echo "您好，" . cookie('user_name') . ', <a href="' . url('login/loginout') . '">退出</a><br/>';
        }
      
        $city = cookie('city');
        if(empty($city)){
          echo '您还未输入查询城市，点击跳转至<a href="' . url('forecast/index') . '">查询页面</a><br/>';
        }else{
          $city = new City();
          $data = $city->read_directly(cookie('city'));
          echo "【" . $data["city"] . "天气预报】<br/>";
          echo str_replace("\n","<br/>",$data["weather_info"]);
        }
    }   
}