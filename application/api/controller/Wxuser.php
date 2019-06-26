<?php 
namespace app\api\controller;

use think\Controller;
use think\Db;

class Wxuser extends Controller
{
    public function getopenid()
    {
    	$param = input('get.');
      	$appid = $param["appid"];
      	$secret = $param["secret"];
      	$code = $param["code"];
      	$url = "https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$secret&js_code=$code&grant_type=authorization_code";
      	$weixin =  file_get_contents($url);
        $jsondecode = json_decode($weixin); //对JSON格式的字符串进行编码
        $array = get_object_vars($jsondecode);//转换成数组
        $openid = $array['openid'];//输出openid
      	$data = [
            'openid' => $openid,
        ];
        return json($data);
    }
    public function save()
    {
        $param = input('post.');
        $postdata = [
          'open_id'=> $param['open_id'],
          'name' => $param['name'],
          'card_number' => $param['card_number'],
          'identity_type' => $param['identity_type'],
          'school_id' => $param['school_id'],
          'weixiao_stu_id' => $param['weixiao_stu_id'],
        ];
        $model = model('app\api\model\Wxuser');

        //部门表添加操作
        $ret = $model->selectForm(['open_id'=> $param['open_id'],]);
        if(count($ret)!=0){
          $res = $model->updateForm(['open_id'=> $param['open_id'],],$postdata);
        }else {
          $res = $model->saveForm($postdata);
        }

        $data = [
          'result' => $ret,
        ];
        return json($data);
    }
  	public function find()
    {
        $param = input('post.');
        $postdata = [
          'open_id'=> $param['open_id'],
        ];
        $model = model('app\api\model\Wxuser');

        $code = 200;
        $res = "";
      
        //部门表添加操作
        $ret = $model->selectForm($postdata);
        if(count($ret)!=1){
          $code = 301;
        }else {
          $res = $model->findForm($postdata);
        }

        $data = [
          'code' => $code,
          'result' => $res,
        ];
        return json($data);
    }
}