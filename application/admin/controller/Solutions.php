<?php

namespace app\admin\controller;
use think\Config;
use think\Loader;
use think\Db;
use app\admin\model\SolutionsModel;
use app\admin\model\SoluCateModel;
//解决方案管理控制器
class Solutions extends Base{
	
	/**
	 * 解决方案列表
	 */
	public function sol_list(){
		$key = input('key');
        $map = [];
        if($key&&$key!==""){
            $map['title'] = ['like',"%" . $key . "%"];          
        }       
        $Nowpage = input('get.page') ? input('get.page'):1;
        $limits = config('list_rows');// 获取总条数
        $count = Db::name('article')->where($map)->count();//计算总页面
        $allpage = intval(ceil($count / $limits));
        $article = new SolutionsModel();
        $lists = $article->getArticleByWhere($map, $Nowpage, $limits);
        $this->assign('Nowpage', $Nowpage); //当前页
        $this->assign('allpage', $allpage); //总页数
        $this->assign('count', $count); 
        $this->assign('val', $key);
//		p($lists);
        if(input('get.page')){
            return json($lists);
        }
        return $this->fetch();
	}
	
	/**
     * [article_state 方案状态]
     * @return [type] [description]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function sol_state()
    {
        $id=input('param.id');
        $status = Db::name('solutions')->where(array('id'=>$id))->value('is_on');//判断当前状态情况
        if($status==1)
        {
            $flag = Db::name('solutions')->where(array('id'=>$id))->setField(['is_on'=>0]);
            return json(['code' => 1, 'data' => $flag['data'], 'msg' => '已禁止']);
        }
        else
        {
            $flag = Db::name('solutions')->where(array('id'=>$id))->setField(['is_on'=>1]);
            return json(['code' => 0, 'data' => $flag['data'], 'msg' => '已开启']);
        }
    
    }
	
	 /**
     * [del_article 删除文章]
     * @return [type] [description]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function del_article()
    {
        $id = input('param.id');
        $cate = new SolutionsModel();
        $flag = $cate->delArticle($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }
	
	/**
     * [add_article 添加文章]
     * @return [type] [description]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function add_solu()
    {
        if(request()->isAjax()){

            $param = input('post.');
            $article = new SolutionsModel();
            $flag = $article->insertSolu($param);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
		
        $cate = new SoluCateModel();
        $this->assign('cate',$cate->getAllCate());
        return $this->fetch();
    }
	
	
	 /**
     * [edit_article 编辑文章]
     * @return [type] [description]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function edit_solu()
    {
        $article = new SolutionsModel(); 
		   
        if(request()->isAjax()){

            $param = input('post.');         
            $flag = $article->updateArticle($param);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.id');
		
        $cate = new SoluCateModel();
//		p($cate->getAllCate());
        $this->assign('cate',$cate->getAllCate());
        $this->assign('article',$article->getOneArticle($id));
        return $this->fetch();
    }
	
	
	//***************************************方案分类**************************
	/**
	 * 方案类型列表
	 */
	public function solu_cate(){
		$cate = new SoluCateModel();
        $list = $cate->getAllCate();
        $this->assign('list',$list);
        return $this->fetch();
	}
   	
	
	/**
	 * 方案类型状态
	 */
	public function solu_cate_state(){
        $id=input('param.id');
        $status = Db::name('solutions_cate')->where(array('id'=>$id))->value('is_on');//判断当前状态情况
        if($status==1)
        {
            $flag = Db::name('solutions_cate')->where(array('id'=>$id))->setField(['is_on'=>0]);
            return json(['code' => 1, 'data' => $flag['data'], 'msg' => '已禁止']);
        }
        else
        {
            $flag = Db::name('solutions_cate')->where(array('id'=>$id))->setField(['is_on'=>1]);
            return json(['code' => 0, 'data' => $flag['data'], 'msg' => '已开启']);
        }
    
    }
	
	/**
     * [del_cate 删除分类]
     * @return [type] [description]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function del_cate(){
        $id = input('param.id');
        $cate = new SoluCateModel();
        $flag = $cate->delCate($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }
	
	/**
     * [add_cate 添加分类]
     * @return [type] [description]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function add_cate(){
        if(request()->isAjax()){

            $param = input('post.');
            $cate = new SoluCateModel();
            $flag = $cate->insertCate($param);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        return $this->fetch();
    }
	
	
	/**
     * [edit_cate 编辑分类]
     * @return [type] [description]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function edit_cate()
    {
        $cate = new SoluCateModel();

        if(request()->isAjax()){

            $param = input('post.');
            $flag = $cate->editCate($param);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.id');
        $this->assign('cate',$cate->getOneCate($id));
        return $this->fetch();
    }
}
