<?php

namespace app\admin\controller;
use think\Config;
use think\Loader;
use think\Db;
use app\admin\model\EntsModel;
use app\admin\model\CustModel;
//官网首页管理控制器
class Ents extends Base{
	
	/**
	 * 首页轮播图
	 */
	public function index_img(){
		$map = [];     
        $Nowpage = input('get.page') ? input('get.page'):1;
        $limits = config('list_rows');// 获取总条数
        $count = Db::name('index_img')->count();//计算总页面
        $allpage = intval(ceil($count / $limits));
        $ents = new EntsModel();
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
        $cate = new EntsModel();
        $flag = $cate->delArticle($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        
	}
	
	/**
	 * 更改轮播图的启用状态
	 */
	public function article_state(){
        $id=input('param.id');
        $status = Db::name('index_img')->where(array('id'=>$id))->value('is_on');//判断当前状态情况
        if($status==1)
        {
            $flag = Db::name('index_img')->where(array('id'=>$id))->setField(['is_on'=>0]);
            return json(['code' => 1, 'data' => $flag['data'], 'msg' => '已禁止']);
        }
        else
        {
            $flag = Db::name('index_img')->where(array('id'=>$id))->setField(['is_on'=>1]);
            return json(['code' => 0, 'data' => $flag['data'], 'msg' => '已开启']);
        }
    
    }
	
	/**
	 * 添加轮播图
	 */
	public function add_index_img(){
		if(request()->isAjax()){

            $param = input('post.');
            $article = new EntsModel();
            $flag = $article->insertArticle($param);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
        return $this->fetch();
	}
	
	
	//******************************************************************************************************
	//*******************************************服务客户****************************************************
	//******************************************************************************************************
	
	
	/**
	 * 服务客户图标
	 */
	public function cust_img(){
		$map = [];     
        $Nowpage = input('get.page') ? input('get.page'):1;
        $limits = config('list_rows');// 获取总条数
        $count = Db::name('cust_img')->count();//计算总页面
        $allpage = intval(ceil($count / $limits));
        $ents = new CustModel();
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
	 * 删除客户图标
	 */
	public function del_imgs(){
		$id = input('param.id');
        $cate = new CustModel();
        $flag = $cate->delArticle($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        
	}
	
	/**
	 * 更改客户图标的启用状态
	 */
	public function article_states(){
        $id=input('param.id');
        $status = Db::name('cust_img')->where(array('id'=>$id))->value('is_on');//判断当前状态情况
        if($status==1)
        {
            $flag = Db::name('cust_img')->where(array('id'=>$id))->setField(['is_on'=>0]);
            return json(['code' => 1, 'data' => $flag['data'], 'msg' => '已禁止']);
        }
        else
        {
            $flag = Db::name('cust_img')->where(array('id'=>$id))->setField(['is_on'=>1]);
            return json(['code' => 0, 'data' => $flag['data'], 'msg' => '已开启']);
        }
    
    }

	/**
	 * 添加轮播图
	 */
	public function add_cust_img(){
		if(request()->isAjax()){

            $param = input('post.');
            $article = new CustModel();
            $flag = $article->insertArticle($param);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
        return $this->fetch();
	}
}
