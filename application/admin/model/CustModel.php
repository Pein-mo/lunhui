<?php

namespace app\admin\model;
use think\Model;
use think\Db;


class CustModel extends Model
{
    protected $name = 'cust_img';
    
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = true;


    /**
     * 获取轮播图列表信息
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function getArticleByWhere($map, $Nowpage, $limits)
    {
        return $this->where($map)->page($Nowpage, $limits)->order('id desc')->select();
    }
    
    
    /**
     * [insertArticle 添加缩略图]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function insertArticle($param)
    {
        try{
            $result = $this->allowField(true)->save($param);
            if(false === $result){             
                return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
            }else{
                return ['code' => 1, 'data' => '', 'msg' => '缩略图添加成功'];
            }
        }catch( PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }



    /**
     * [updateArticle 编辑缩略图]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function updateArticle($param)
    {
        try{
            $result = $this->allowField(true)->save($param, ['id' => $param['id']]);
            if(false === $result){          
                return ['code' => 0, 'data' => '', 'msg' => $this->getError()];
            }else{
                return ['code' => 1, 'data' => '', 'msg' => '轮播图编辑成功'];
            }
        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }



 



    /**
     * [delArticle 删除缩略图]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function delArticle($id){
    	$img = $this->where('id',$id)->value('img');
		$img = $_SERVER['DOCUMENT_ROOT'].'/uploads/images/'.$img;
		if(is_file($img)){
			unlink($img);
		}
        try{
            $this->where('id', $id)->delete();
            return ['code' => 1, 'data' => '', 'msg' => '轮播图删除成功'];
        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

}