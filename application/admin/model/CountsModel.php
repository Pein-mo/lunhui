<?php

namespace app\admin\model;
use think\Model;

class CountsModel extends Model
{
    protected $name = 'counts';

    /**
     * 删除日志
     */
    public function del($id)
    {
        try{
            $this->where('id', $id)->delete();
            return ['code' => 1, 'data' => '', 'msg' => '删除日志成功'];
        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

}