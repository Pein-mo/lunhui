<?php

namespace app\admin\controller;
use think\Config;
use think\Loader;
use think\Db;
use app\admin\model\OfficeModel;
//关于我们管理控制器
class About extends Base{

	/**
	 * 办公图片列表
	 */
	public function office_img(){
		$map = [];     
        $Nowpage = input('get.page') ? input('get.page'):1;
        $limits = config('list_rows');// 获取总条数
        $count = Db::name('office')->count();//计算总页面
        $allpage = intval(ceil($count / $limits));
        $ents = new OfficeModel();
        $lists = $ents->getArticleByWhere($map, $Nowpage, $limits);
        $this->assign('Nowpage', $Nowpage); //当前页
        $this->assign('allpage', $allpage); //总页数
        $this->assign('count', $count); 
        if(input('get.page')){
            return json($lists);
        }
        return $this->fetch();
	}
   
   	/**
	 * 删除轮播图
	 */
	public function del_img(){
		$id = input('param.id');
        $cate = new OfficeModel();
        $flag = $cate->delArticle($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        
	}
	
	/**
	 * 更改轮播图的启用状态
	 */
	public function office_state(){
        $id=input('param.id');
        $status = Db::name('office')->where(array('id'=>$id))->value('status');//判断当前状态情况
        if($status==1)
        {
            $flag = Db::name('office')->where(array('id'=>$id))->setField(['status'=>0]);
            return json(['code' => 1, 'data' => $flag['data'], 'msg' => '已禁止']);
        }
        else
        {
            $flag = Db::name('office')->where(array('id'=>$id))->setField(['status'=>1]);
            return json(['code' => 0, 'data' => $flag['data'], 'msg' => '已开启']);
        }
    
    }
	
	/**
	 * 添加轮播图
	 */
	public function add_office_img(){
		if(request()->isAjax()){

            $param = input('post.');
            $article = new OfficeModel();
            $flag = $article->insertArticle($param);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
        return $this->fetch();
	}
}
