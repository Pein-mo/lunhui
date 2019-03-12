<?php

namespace app\admin\controller;
use think\Config;
use think\Loader;
use think\Db;
use app\admin\model\CustomerModel;
//客户案例管理控制器
class Customer extends Base{
	
	/**
	 * 案例列表
	 */
	public function cust_list(){
		$key = input('key');
        $map = [];
        if($key&&$key!==""){
            $map['title'] = ['like',"%" . $key . "%"];          
        }       
        $Nowpage = input('get.page') ? input('get.page'):1;
        $limits = config('list_rows');// 获取总条数
        $count = Db::name('customer')->where($map)->count();//计算总页面
        $allpage = intval(ceil($count / $limits));
        $article = new CustomerModel();
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
    public function add_cust()
    {
        if(request()->isAjax()){

            $param = input('post.');
            $article = new CustomerModel();
            $flag = $article->insertArticle($param);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
        return $this->fetch();
    }


    /**
     * [edit_article 编辑文章]
     * @return [type] [description]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function edit_cust()
    {
        $article = new CustomerModel();     
        if(request()->isAjax()){

            $param = input('post.');         
            $flag = $article->updateArticle($param);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.id');
        
        $this->assign('article',$article->getOneArticle($id));
        return $this->fetch();
    }



    /**
     * [del_article 删除文章]
     * @return [type] [description]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function del_cust()
    {
        $id = input('param.id');
        $cate = new CustomerModel();
        $flag = $cate->delArticle($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }



    /**
     * [article_state 文章状态]
     * @return [type] [description]
     * @author [莫镇柱] [251439200@qq.com]
     */
    public function cust_state()
    {
        $id=input('param.id');
        $status = Db::name('customer')->where(array('id'=>$id))->value('is_on');//判断当前状态情况
        if($status==1)
        {
            $flag = Db::name('customer')->where(array('id'=>$id))->setField(['is_on'=>0]);
            return json(['code' => 1, 'data' => $flag['data'], 'msg' => '已禁止']);
        }
        else
        {
            $flag = Db::name('customer')->where(array('id'=>$id))->setField(['is_on'=>1]);
            return json(['code' => 0, 'data' => $flag['data'], 'msg' => '已开启']);
        }
    
    }
	
}
