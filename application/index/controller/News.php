<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
//网站首页
class News extends Base{

    public function index(){
		$data = Db::name('news')->field('think_news.*,name')->join('think_news_cate', 'think_news.cate_id = think_news_cate.id')->where('think_news.status',1)->order('id desc')->paginate(6);
		$hot = Db::name('news')->order('views desc')->limit(5)->select();
		$this->assign('hot',$hot);
		$this->assign('data',$data);
		$this->assign('menu','news');
        return $this->fetch();
    }
	
	/**
	 * 新闻详情
	 */
	public function info(){
		$id = input('param.id');
		Db::name('news')->where('id',$id)->setInc('views');
		$data = Db::name('news')->where('status','1')->where('id',$id)->find();
		$this->assign('data',$data);
		$this->assign('menu','news');
		return $this->fetch();
	}
}
