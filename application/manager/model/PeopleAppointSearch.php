<?php

/*
 * 用于获取数据库的model
 * 即导出Excel的数据*/

namespace app\manager\model;

use think\Model;
use think\Db;


class PeopleAppointSearch extends Model{
    // 获取数据库信息
    public function getinfo(){
        $info = Db::table('car_license')
            ->field('usr_name,usr_number,type,department,usr_phone,people_name,people_phone,people_number,reason,apply_data,period,note,apply_data')
            ->select();
        return $info;
    }

}