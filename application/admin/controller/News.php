<?php

namespace app\admin\controller;
use think\Config;
use think\Loader;
use think\Db;
use app\admin\model\NewsModel;
use app\admin\model\NewsCateModel;
//新闻管理控制器
class News extends Base{
	
	/**
	 * 新闻列表
	 */
	public function news_list(){
		$key = input('key');
        $map = [];
        if($key&&$key!==""){
            $map['title'] = ['like',"%" . $key . "%"];          
        }       
        $Nowpage = input('get.page') ? input('get.page'):1;
        $limits = config('list_rows');// 获取总条数
        $count = Db::name('news')->where($map)->count();//计算总页面
        $allpage = intval(ceil($count / $limits));
        $article = new NewsModel();
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
     * [add_article 添加文章]
     * @return [type] [description]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function add_news()
    {
        if(request()->isAjax()){

            $param = input('post.');
            $article = new NewsModel();
            $flag = $article->insertArticle($param);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
		
        $cate = new NewsCateModel();
        $this->assign('cate',$cate->getAllCate());
        return $this->fetch();
    }


    /**
     * [edit_article 编辑文章]
     * @return [type] [description]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function edit_news()
    {
        $article = new NewsModel();     
        if(request()->isAjax()){

            $param = input('post.');         
            $flag = $article->updateArticle($param);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.id');
        $cate = new NewsCateModel();
        $this->assign('cate',$cate->getAllCate());
        $this->assign('article',$article->getOneArticle($id));
        return $this->fetch();
    }



    /**
     * [del_article 删除文章]
     * @return [type] [description]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function del_news()
    {
        $id = input('param.id');
        $cate = new NewsModel();
        $flag = $cate->delArticle($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }



    /**
     * [article_state 文章状态]
     * @return [type] [description]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function news_state()
    {
        $id=input('param.id');
        $status = Db::name('news')->where(array('id'=>$id))->value('status');//判断当前状态情况
        if($status==1)
        {
            $flag = Db::name('news')->where(array('id'=>$id))->setField(['status'=>0]);
            return json(['code' => 1, 'data' => $flag['data'], 'msg' => '已禁止']);
        }
        else
        {
            $flag = Db::name('news')->where(array('id'=>$id))->setField(['status'=>1]);
            return json(['code' => 0, 'data' => $flag['data'], 'msg' => '已开启']);
        }
    
    }



    //*********************************************分类管理*********************************************//

    /**
     * [index_cate 分类列表]
     * @return [type] [description]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function index_cate(){

        $cate = new NewsCateModel();
        $list = $cate->getAllCate();
        $this->assign('list',$list);
        return $this->fetch();
    }


    /**
     * [add_cate 添加分类]
     * @return [type] [description]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function add_cate()
    {
        if(request()->isAjax()){

            $param = input('post.');
            $cate = new NewsCateModel();
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
        $cate = new NewsCateModel();

        if(request()->isAjax()){

            $param = input('post.');
            $flag = $cate->editCate($param);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.id');
        $this->assign('cate',$cate->getOneCate($id));
        return $this->fetch();
    }


    /**
     * [del_cate 删除分类]
     * @return [type] [description]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function del_cate()
    {
        $id = input('param.id');
        $cate = new NewsCateModel();
        $flag = $cate->delCate($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }



    /**
     * [cate_state 分类状态]
     * @return [type] [description]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function cate_state()
    {
        $id=input('param.id');
        $status = Db::name('article_cate')->where(array('id'=>$id))->value('status');//判断当前状态情况
        if($status==1)
        {
            $flag = Db::name('article_cate')->where(array('id'=>$id))->setField(['status'=>0]);
            return json(['code' => 1, 'data' => $flag['data'], 'msg' => '已禁止']);
        }
        else
        {
            $flag = Db::name('article_cate')->where(array('id'=>$id))->setField(['status'=>1]);
            return json(['code' => 0, 'data' => $flag['data'], 'msg' => '已开启']);
        }
    
    }
	
   
}
