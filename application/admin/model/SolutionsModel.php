<?php

namespace app\admin\model;
use think\Model;
use think\Db;

class SolutionsModel extends Model
{
    protected $name = 'solutions';
    
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = true;


    /**
     * 根据搜索条件获取用户列表信息
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function getArticleByWhere($map, $Nowpage, $limits)
    {
        return $this->field('think_solutions.*,name')->join('think_solutions_cate', 'think_solutions.cate_id = think_solutions_cate.id')->where($map)->page($Nowpage, $limits)->order('id desc')->select();
    }
    
    
    /**
     * [insertArticle 添加文章]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function insertSolu($param)
    {
        try{
            $result = $this->allowField(true)->save($param);
            if(false === $result){             
                return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
            }else{
                return ['code' => 1, 'data' => '', 'msg' => '文章添加成功'];
            }
        }catch( PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }



    /**
     * [updateArticle 编辑文章]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function updateArticle($param)
    {
        try{
            $result = $this->allowField(true)->save($param, ['id' => $param['id']]);
            if(false === $result){          
                return ['code' => 0, 'data' => '', 'msg' => $this->getError()];
            }else{
                return ['code' => 1, 'data' => '', 'msg' => '文章编辑成功'];
            }
        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }



    /**
     * [getOneArticle 根据文章id获取一条信息]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function getOneArticle($id)
    {
        return $this->where('id', $id)->find();
    }



    /**
     * [delArticle 删除文章]
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
            return ['code' => 1, 'data' => '', 'msg' => '文章删除成功'];
        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

}