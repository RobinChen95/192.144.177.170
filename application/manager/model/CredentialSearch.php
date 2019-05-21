<?php

/*
 * 用于获取数据库的model
 * 即导出Excel的数据*/

class credential_search extends Model
{
    // 获取数据库信息
    public function getinfo()
    {
        $info = Db::table('car_license')
            ->field('usr_name,usr_number,type,department,usr_phone,car_number,car_owner,note,apply_date,pass_date,valid_date,status')
            ->select();
        return $info;
    }

    // 用于导入Excel数据表
    public function insertAllUser($data)
    {
        return Db::table('car_license')->insertAll($data);
    }

    // 用于导入Excel数据表，防止重复添加
    public function findUserByWorkId($workId)
    {
        return Db::table('car_license')
            ->where('usr_number', $workId)
            ->where('isvalid', 1)
            ->find();
    }
}